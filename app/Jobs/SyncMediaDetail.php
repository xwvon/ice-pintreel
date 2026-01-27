<?php

namespace App\Jobs;

use AlibabaCloud\Credentials\Credential;
use AlibabaCloud\SDK\ICE\V20201109\ICE;
use AlibabaCloud\SDK\ICE\V20201109\Models\GetMediaInfoRequest;
use AlibabaCloud\Tea\Exception\TeaUnableRetryError;
use App\Helper;
use App\Models\MediaInfo;
use Darabonba\OpenApi\Models\Config;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use ReflectionException;
use App\Events\ProduceMediaComplete;

class SyncMediaDetail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $params;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try {
            $data = $this->getModelAndRequest();
            /**
             * @var MediaInfo $model
             * @var GetMediaInfoRequest $request
             */
            $model   = $data['model'];
            $request = $data['request'];
            event(new ProduceMediaComplete($this->params['params'], $model->user_id));
            $this->fetchMediaInfo($model, $request);

        } catch (Exception|TeaUnableRetryError|ReflectionException $e) {
            $this->error(500, $e->getMessage());
        }
        //
    }

    /**
     * @return array ["model"]
     * @throws Exception
     */
    private function getModelAndRequest()
    {
        if (!isset($this->params['user_id'])) {
            throw new Exception('参数错误');
        }
        if (isset($this->params['media_id'])) {
            return $this->getModelByMediaId();
        }
        if (isset($this->params['client_token'])) {
            return $this->getModelByClientToken();
        }
        if (isset($this->params['input_url'])) {
            return $this->getModelByInputUrl();
        }
        throw new Exception('参数错误');
    }

    /**
     * @return array
     * @throws Exception
     */
    private function getModelByMediaId(): array
    {
        $model = MediaInfo::query()
            ->where('user_id', $this->params['user_id'] ?? '')
            ->where('media_id', $this->params['media_id'] ?? '')
            ->first();
        if (!$model) {
            throw new Exception('未找到媒体信息');
        }
        if (!$model->media_id) {
            throw new Exception('媒体信息未注册');
        }

        $request          = new GetMediaInfoRequest();
        $request->mediaId = $model->media_id;
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
        $model = MediaInfo::query()
            ->where('user_id', $this->params['user_id'] ?? '')
            ->where('client_token', $this->params['client_token'] ?? '')
            ->first();
        if (!$model) {
            throw new Exception('未找到媒体信息');
        }
        if (!$model->media_id) {
            throw new Exception('媒体信息未注册');
        }

        $request          = new GetMediaInfoRequest();
        $request->mediaId = $model->media_id;
        return [
            'model'   => $model,
            'request' => $request,
        ];
    }

    /**
     * @return array
     */
    private function getModelByInputUrl(): array
    {
        $model = MediaInfo::query()
            ->where('user_id', $this->params['user_id'] ?? '')
            ->where('media_basic_info.input_url', $this->params['input_url'] ?? '')
            ->first();
        if (!$model) {
            $model          = new MediaInfo([
                                                'media_basic_info' => [
                                                    'input_url' => $this->params['input_url'] ?? '',
                                                ],
                                            ]);
            $model->user_id = $this->params['user_id'] ?? '';
        }
        $request           = new GetMediaInfoRequest();
        $request->inputURL = $model->media_basic_info['input_url'] ?? '';
        return [
            'model'   => $model,
            'request' => $request,
        ];
    }

    /**
     * @param MediaInfo $model
     * @param GetMediaInfoRequest $request
     * @return void
     * @throws ReflectionException
     */
    private function fetchMediaInfo(MediaInfo $model, GetMediaInfoRequest $request)
    {
        $credential = new Credential([
                                         'type'              => 'access_key',
                                         'access_key_id'     => \config('aliyun.access_key_id'),
                                         'access_key_secret' => \config('aliyun.access_key_secret'),
                                     ]);
        $config     = new Config([
                                     'credential' => $credential,
                                     'endpoint'   => config('aliyun.ice.default.endpoint'),
                                 ]);
        $client     = new ICE($config);
        $request->returnDetailedInfo = '{"AiRoughData.StandardSmartTagJob": true}';
        $response   = $client->getMediaInfo($request);
        if ($response->statusCode != 200) {
            $this->error($response->statusCode, '操作失败');
            return;
        }
        $data = $response->body->mediaInfo->toMap();
        $data = Helper::arrayKeySnake($data);
        $model->forceFill($data);
        $model->save();
        $this->success($model->toArray());
    }

    private function error($code, $message)
    {
        Log::error($message, ['code' => $code]);
        // return [
        //     'code'    => $code,
        //     'message' => $message,
        // ];
    }

    private function success($data = [])
    {
        Log::info('success', ['params' => $this->params]);

        // return [
        //     'code'    => 200,
        //     'message' => 'success',
        //     'data'    => $data,
        // ];
    }
}
