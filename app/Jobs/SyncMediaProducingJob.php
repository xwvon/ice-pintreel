<?php

namespace App\Jobs;

use AlibabaCloud\Credentials\Credential;
use AlibabaCloud\SDK\ICE\V20201109\ICE;
use AlibabaCloud\SDK\ICE\V20201109\Models\GetMediaProducingJobRequest;
use AlibabaCloud\Tea\Exception\TeaUnableRetryError;
use App\Helper;
use App\Models\MediaProducingJob;
use Darabonba\OpenApi\Models\Config;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncMediaProducingJob extends BaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        try {
            $data = $this->getModelAndRequest();
            /**
             * @var MediaProducingJob $model
             * @var GetMediaProducingJobRequest $clientRequest
             */
            $model         = $data['model'];
            $clientRequest = $data['request'];
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
            $response      = $client->getMediaProducingJob($clientRequest);

            if ($response->statusCode != 200) {
                return $this->error($response->statusCode, '操作失败');
            }
            $res = $response->body->mediaProducingJob->toMap();
            $model->forceFill(Helper::arrayKeySnake($res));
            $model->save();
            $this->syncMedia($model);
            return $this->success($res);
        } catch (Exception|TeaUnableRetryError $e) {
            return $this->error(500, [
                'code'    => $e->getCode(),
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);
        }
    }

    /**
     * @return array ["model"]
     * @throws Exception
     */
    private function getModelAndRequest()
    {
        if (!isset($this->params['user_id'])) {
            throw new Exception('参数错误, user_id 必填');
        }
        if (!empty($this->params['job_id'])) {
            return $this->getModelByJobId();
        }
        if (!empty($this->params['client_token'])) {
            return $this->getModelByClientToken();
        }
        throw new Exception('参数错误, job_id 或 client_token 必填');
    }

    /**
     * @return array
     * @throws Exception
     */
    private function getModelByJobId(): array
    {
        $model = MediaProducingJob::query()
            ->where('user_id', $this->params['user_id'] ?? '')
            ->where('job_id', $this->params['job_id'] ?? '')
            ->first();
        if (!$model) {
            throw new Exception('未找到媒体信息');
        }
        if (!$model->job_id) {
            throw new Exception('媒体信息未注册');
        }

        $request        = new GetMediaProducingJobRequest();
        $request->jobId = $model->job_id;
        return [
            'model'   => $model,
            'request' => $request,
        ];
    }

    /**
     * @return array
     * @throws Exception
     */
    private function getModelByClientToken(): array
    {
        $model = MediaProducingJob::query()
            ->where('user_id', $this->params['user_id'] ?? '')
            ->where('client_token', $this->params['client_token'] ?? '')
            ->first();
        if (!$model) {
            throw new Exception('未找到媒体信息');
        }
        if (!$model->job_id) {
            throw new Exception('媒体信息未注册');
        }

        $request        = new GetMediaProducingJobRequest();
        $request->jobId = $model->job_id;
        return [
            'model'   => $model,
            'request' => $request,
        ];
    }

    private function syncMedia(MediaProducingJob $model)
    {
        // 未完成返回
        if ($model->status !== 'Success') {
            // return;
        }

        $mediaUrl = $model->media_url;
        // 云剪辑完成, 同步媒体库数据
        SyncMediaDetail::dispatch(["user_id" => $model->user_id, "input_url" => $mediaUrl, 'params' => $this->params['params']]);
    }
}
