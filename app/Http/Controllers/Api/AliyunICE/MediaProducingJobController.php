<?php

namespace App\Http\Controllers\Api\AliyunICE;

use AlibabaCloud\Credentials\Credential;
use AlibabaCloud\SDK\ICE\V20201109\ICE;
use AlibabaCloud\SDK\ICE\V20201109\Models\SubmitMediaProducingJobRequest;
use AlibabaCloud\Tea\Exception\TeaUnableRetryError;
use App\Helper;
use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\AliyunICE\MediaProducingJob\CreateRequest;
use App\Http\Requests\AliyunICE\MediaProducingJob\SyncRequest;
use App\Jobs\SyncMediaProducingJob;
use App\Models\MediaProducingJob;
use Darabonba\OpenApi\Models\Config;
use Exception;
use Illuminate\Http\JsonResponse;

class MediaProducingJobController extends ApiBaseController
{
    public function create(CreateRequest $request)
    {
        $model = MediaProducingJob::query()
            ->where('user_id', $request->user()->id)
            ->where('client_token', $request->client_token)
            ->first();

        if (!$model) {
            $model            = new MediaProducingJob();
            $model->user_id   = $request->user()->id;
            $model->user_data = [
                // 'notify_address' => $request->getSchemeAndHttpHost() . '/api/aliyun-ice/media-producing-job/hook',
                'notify_address' => $request->getSchemeAndHttpHost() . '/api/aliyun-ice/callback',
                'user_id'        => $request->user()->id,
                'client_token'   => $request->client_token,
            ];
            $model->status = 0;
            
        }

        if ($model->job_id) {
            return $this->success();
        }

        $model->fill($request->validated());
        // $filename = uniqid();
        $filename = $request->output_media_config['name'];
        $username = $request->user()->username;
        $model->output_media_config = [
            'media_url'       => "https://" . env('ALIYUN_OSS_BUCKET') . ".oss-cn-shanghai.aliyuncs.com/{$username}/{$filename}.mp4",
        ];
        $model->save();
        return $this->submit($model);
    }

    private function submit(MediaProducingJob $model)
    {
        try {
            $credential    = new Credential([
                                                'type'              => 'access_key',
                                                'access_key_id'     => config('aliyun.access_key_id'),
                                                'access_key_secret' => config('aliyun.access_key_secret'),
                                            ]);
            $config        = new Config([
                                            'credential' => $credential,
                                            'endpoint'   => config('aliyun.ice.default.endpoint'),
                                        ]);
            $client        = new ICE($config);
            $clientRequest = new SubmitMediaProducingJobRequest($model->getDataForSubmit());
            $response      = $client->submitMediaProducingJob($clientRequest);

            if ($response->statusCode != 200) {
                return $this->error($response->statusCode, '操作失败');
            }
            $data = $response->body->toMap();
            $model->fill(Helper::arrayKeySnake($data));
            $model->save();
            return $this->success($data);
        } catch (Exception|TeaUnableRetryError $e) {
            return $this->error(500, $e->getMessage());
        }
    }

    /**
     * 同步任务, 从阿里云同步到本地数据库
     * @param SyncRequest $request
     * @return JsonResponse
     * @throws TeaUnableRetryError
     * @throws Exception
     */
    public function sync(SyncRequest $request): JsonResponse
    {
        SyncMediaProducingJob::dispatch([
                                            "user_id"      => $request->user()->id,
                                            "job_id"       => $request->job_id,
                                            "client_token" => $request->client_token,
                                        ]);
        return $this->success();
    }
}
