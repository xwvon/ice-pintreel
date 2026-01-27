<?php

namespace App\Jobs;

use AlibabaCloud\Credentials\Credential;
use AlibabaCloud\SDK\ICE\V20201109\ICE;
use AlibabaCloud\SDK\ICE\V20201109\Models\ListMediaBasicInfosRequest;
use AlibabaCloud\SDK\ICE\V20201109\Models\ListMediaBasicInfosResponse;
use AlibabaCloud\Tea\Exception\TeaUnableRetryError;
use App\Helper;
use App\Models\MediaInfo;
use Darabonba\OpenApi\Models\Config;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use ReflectionException;

class SyncMediaList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var mixed|null
     */
    private $nextToken;
    private $params;
    private $userId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId, $params = [], $nextToken = null)
    {
        $this->userId    = $userId;
        $this->params    = $params;
        $this->nextToken = $nextToken;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $credential          = new Credential([
                                                      'type'              => 'access_key',
                                                      'access_key_id'     => \config('aliyun.access_key_id'),
                                                      'access_key_secret' => \config('aliyun.access_key_secret'),
                                                  ]);
            $config              = new Config([
                                                  'credential' => $credential,
                                                  'endpoint'   => config('aliyun.ice.default.endpoint'),
                                              ]);
            $client              = new ICE($config);
            $request             = new ListMediaBasicInfosRequest();
            $request->maxResults = 100;
            if (!$this->nextToken) {
                $request->nextToken = $this->nextToken;
            }
            $response = $client->listMediaBasicInfos($request);
            if ($response->statusCode != 200) {
                $this->error($response->statusCode, '操作失败');
                return;
            }
            $this->save($response->body->toMap());
            $this->success();
            $this->next($response);
        } catch (TeaUnableRetryError|ReflectionException $e) {
            $this->error(500, $e->getMessage());
        }
    }

    private function error($code, $message)
    {
        Log::error($message, ['code' => $code]);
    }

    private function save($data)
    {
        $data = Helper::arrayKeySnake($data);
        if (!$data['media_infos']) {
            return;
        }
        foreach ($data['media_infos'] as $item) {
            $model = MediaInfo::query()
                ->where('media_id', $item['media_id'])
                ->first();
            if (!$model) {
                $model          = new MediaInfo();
                $model->user_id = $this->userId;
            }
            $model->forceFill($item);
            $model->save();
        }
    }

    private function success($data = [])
    {
        Log::info('success', ['params' => $this->params]);
    }

    private function next(ListMediaBasicInfosResponse $response)
    {
        if ($response->body->nextToken) {
            SyncMediaList::dispatch($this->userId, $this->params, $response->body->nextToken);
        }
    }
}
