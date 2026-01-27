<?php

namespace App\Jobs;

use AlibabaCloud\Credentials\Credential;
use AlibabaCloud\SDK\ICE\V20201109\ICE;
use AlibabaCloud\SDK\ICE\V20201109\Models\GetBatchMediaProducingJobRequest;
use AlibabaCloud\Tea\Exception\TeaUnableRetryError;
use App\Helper;
use App\Models\BatchMediaProducingJob;
use Darabonba\OpenApi\Models\Config;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ReflectionException;

class SyncBatchMediaProducingJob extends BaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle(): bool
    {
        //

        try {
            $params = $this->getModelAndRequest();
            /**
             * @var BatchMediaProducingJob $model
             * @var GetBatchMediaProducingJobRequest $clientRequest
             */
            $model          = $params['model'];
            $clientRequest = $params['request'];
            $credential           = new Credential([
                                                       'type'              => 'access_key',
                                                       'access_key_id'     => config('aliyun.access_key_id'),
                                                       'access_key_secret' => config('aliyun.access_key_secret'),
                                                   ]);
            $config               = new Config([
                                                   'credential' => $credential,
                                                   'endpoint'   => config('aliyun.ice.default.endpoint'),
                                               ]);
            $client               = new ICE($config);
            $response             = $client->getBatchMediaProducingJob($clientRequest);
            if ($response->statusCode != 200) {
                return $this->error($response->statusCode, '操作失败');
            }
            $data = $response->body->editingBatchJob->toMap();
            $data = Helper::arrayKeySnake($data);
            $model->forceFill($data);
            $model->save();
            $this->syncSubJob($model);
            return $this->success();
        } catch (TeaUnableRetryError|ReflectionException|Exception $e) {
            return $this->error(500, [
                'code'    => $e->getCode(),
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);
        }
    }

    /**
     * @param BatchMediaProducingJob $model
     * @return void
     */
    private function syncSubJob(BatchMediaProducingJob $model)
    {
        foreach ($model->sub_job_list as $subJob) {
            SyncMediaDetail::dispatch(["user_id" => $model->user_id, "input_url" => $subJob['media_url']]);
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
        $model = BatchMediaProducingJob::query()
            ->where('user_id', $this->params['user_id'] ?? '')
            ->where('job_id', $this->params['job_id'] ?? '')
            ->first();
        if (!$model) {
            throw new Exception('未找到媒体信息');
        }
        if (!$model->job_id) {
            throw new Exception('媒体信息未注册');
        }

        $request        = new GetBatchMediaProducingJobRequest();
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
        $model = BatchMediaProducingJob::query()
            ->where('user_id', $this->params['user_id'] ?? '')
            ->where('client_token', $this->params['client_token'] ?? '')
            ->first();
        if (!$model) {
            throw new Exception('未找到媒体信息');
        }
        if (!$model->job_id) {
            throw new Exception('媒体信息未注册');
        }

        $request        = new GetBatchMediaProducingJobRequest();
        $request->jobId = $model->job_id;
        return [
            'model'   => $model,
            'request' => $request,
        ];
    }
}
