<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\UserFile;
use App\Models\MediaInfo;
use ReflectionException;
use AlibabaCloud\Credentials\Credential;
use AlibabaCloud\SDK\ICE\V20201109\ICE;
use AlibabaCloud\SDK\ICE\V20201109\Models\DeleteMediaInfosRequest;
use AlibabaCloud\SDK\ICE\V20201109\Models\RegisterMediaInfoRequest;
use AlibabaCloud\Tea\Exception\TeaUnableRetryError;
use Darabonba\OpenApi\Models\Config;
use Illuminate\Support\Facades\Log;
use App\Events\MediaUploadComplete;

class RegisterMediaInfo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userfile;

    public $clientToken;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(UserFile $userfile, $clientToken)
    {
        $this->userfile = $userfile;
        $this->clientToken = $clientToken;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Log::info("register media info job start");
            $mediaBasicInfo = ['input_url' => $this->userfile->path];
            $model = MediaInfo::query()
                ->where('user_id', $this->userfile->user_id)
                ->where('client_token', $this->clientToken)
                ->first();
            if (!$model) {
                $model            = new MediaInfo(['client_token' => $this->clientToken]);
                $model->user_id   = $this->userfile->user_id;
                $model->user_data = [
                    // 'notify_address' => $request->getSchemeAndHttpHost() . '/api/aliyun-ice/media/hook',
                    'notify_address' => url('/api/aliyun-ice/callback'),
                    'user_id'        => $this->userfile->id,
                    'client_token'   => $this->clientToken,
                ];
            }
            if ($model->media_id) {
                return;
            }
            $data = [
                'media_basic_info' => $mediaBasicInfo,
                'client_token'     => $this->clientToken,
            ];
            $model->fill($data);
            $model->save();
            $credential    = new Credential([
                                                'type'              => 'access_key',
                                                'access_key_id'     => \config('aliyun.access_key_id'),
                                                'access_key_secret' => \config('aliyun.access_key_secret'),
                                            ]);
            $config        = new Config([
                                            'credential' => $credential,
                                            'endpoint'   => config('aliyun.ice.default.endpoint'),
                                        ]);
            $client        = new ICE($config);
            Log::info(json_encode($model->getDataForRegister()));
            $clientRequest = new RegisterMediaInfoRequest($model->getDataForRegister());

            $response = $client->registerMediaInfo($clientRequest);
            if ($response->statusCode != 200) {
                Log::info('registerMediaInfo result ' . json_encode($response));
            }
            $model->media_id = $response->body->mediaId;
            $model->save();
            event(new MediaUploadComplete($model->user_id, ['status' => 'Success', 'media_id' => $model->media_id]));
        } catch (TeaUnableRetryError|ReflectionException $e) {
            Log::info($e->getMessage());
        }
    }
}
