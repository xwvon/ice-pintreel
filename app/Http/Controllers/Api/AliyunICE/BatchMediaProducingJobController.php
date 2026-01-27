<?php

namespace App\Http\Controllers\Api\AliyunICE;

use AlibabaCloud\Credentials\Credential;
use AlibabaCloud\SDK\ICE\V20201109\ICE;
use AlibabaCloud\SDK\ICE\V20201109\Models\SubmitBatchMediaProducingJobRequest;
use AlibabaCloud\Tea\Exception\TeaUnableRetryError;
use App\Helper;
use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\AliyunICE\BatchMediaProducingJob\CreateRequest;
use App\Http\Requests\AliyunICE\BatchMediaProducingJob\DeleteRequest;
use App\Http\Requests\AliyunICE\BatchMediaProducingJob\ListRequest;
use App\Http\Requests\AliyunICE\BatchMediaProducingJob\ShowRequest;
use App\Http\Requests\AliyunICE\BatchMediaProducingJob\SubmitRequest;
use App\Http\Requests\AliyunICE\BatchMediaProducingJob\SyncRequest;
use App\Http\Requests\AliyunICE\BatchMediaProducingJob\UpdateRequest;
use App\Jobs\SyncBatchMediaProducingJob;
use App\Models\BatchMediaProducingJob;
use Darabonba\OpenApi\Models\Config;
use Exception;
use Illuminate\Http\JsonResponse;
use ReflectionException;

class BatchMediaProducingJobController extends ApiBaseController
{
    public function create(CreateRequest $request): JsonResponse
    {
        $data             = $request->validated();
        $data             = Helper::arrayKeySnake($data);
        $model            = new BatchMediaProducingJob($data);
        $model->user_id   = $request->user()->id;
        $model->user_data = [
            // 'notify_address' => $request->getSchemeAndHttpHost() . '/api/aliyun-ice/batch-media-producing-job/hook',
            'notify_address' => $request->getSchemeAndHttpHost() . '/api/aliyun-ice/callback',
            'user_id'        => $request->user()->id,
            'client_token'   => $model->client_token,
        ];
        $filename = $request->output_config['name'];
        $username = $request->user()->username;
        $output_config = $request->output_config;
        unset($output_config['name']);
        $model->output_config = array_merge([
            'media_url'       => "https://" . env('ALIYUN_OSS_BUCKET') . ".oss-cn-shanghai.aliyuncs.com/{$username}/{$filename}_{index}.mp4",
        ], $output_config);
        $model->save();
        return $this->success([
                                  'client_token' => $model->client_token,
                              ]);
    }

    public function submit(SubmitRequest $request): JsonResponse
    {
        try {
            /* @var $model BatchMediaProducingJob */
            $model = BatchMediaProducingJob::query()
                ->where('user_id', $request->user()->id)
                ->where('client_token', $request->client_token)
                ->first();
            if (empty($model)) {
                return $this->error(404, '未找到该任务');
            }
            if ($model->job_id) {
                return $this->success([
                                          'job_id' => $model->job_id,
                                      ]);
            }
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
            $clientRequest = new SubmitBatchMediaProducingJobRequest($model->getDataForSubmit());
            $response      = $client->submitBatchMediaProducingJob($clientRequest);
            if ($response->statusCode != 200) {
                return $this->error($response->statusCode, '操作失败');
            }
            $data = $response->body->toMap();
            $data = Helper::arrayKeySnake($data);
            $model->forceFill($data);
            return $this->success($data);
        } catch (TeaUnableRetryError|ReflectionException $e) {
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
        SyncBatchMediaProducingJob::dispatch([
                                                 "user_id"      => $request->user()->id,
                                                 "client_token" => $request->client_token,
                                                 "job_id"       => $request->job_id,
                                             ]);
        return $this->success();
    }

    public function delete(DeleteRequest $request): JsonResponse
    {
        try {
            $model = BatchMediaProducingJob::query()
                ->where('user_id', $request->user()->id)
                ->where('client_token', $request->client_token)
                ->first();
            if (empty($model)) {
                return $this->error(404, '未找到该任务');
            }
            if ($model->status) {
                return $this->error(400, '任务已提交, 不能删除');
            }
            $model->delete();
            return $this->success();
        } catch (Exception $e) {
            return $this->error(500, \config('app.debug') ? $e->getMessage() : '操作失败');
        }
    }

    public function list(ListRequest $request): JsonResponse
    {
        $model = BatchMediaProducingJob::query()
            ->where('user_id', $request->user()->id)
            ->orderByDesc('id')
            ->paginate($request->per_page ?? 10);
        return $this->page($model);
    }

    public function show(ShowRequest $request): JsonResponse
    {
        $model = BatchMediaProducingJob::query()
            ->where('user_id', $request->user()->id)
            ->where('client_token', $request->client_token)
            ->first();
        if (empty($model)) {
            return $this->error(404, '未找到该任务');
        }
        return $this->success($model->toArray());
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        try {
            $model = BatchMediaProducingJob::query()
                ->where('user_id', $request->user()->id)
                ->where('client_token', $request->client_token)
                ->first();
            if (empty($model)) {
                return $this->error(404, '未找到该任务');
            }
            if ($model->status) {
                return $this->error(400, '任务已提交, 不能修改');
            }
            $model->fill($request->validated());
            $model->save();
            return $this->success([
                                      'client_token' => $model->client_token,
                                  ]);
        } catch (Exception $e) {
            return $this->error(500, \config('app.debug') ? $e->getMessage() : '操作失败');
        }
    }
}
