<?php

namespace App\Http\Controllers\Api\AliyunICE;

use AlibabaCloud\Credentials\Credential;
use AlibabaCloud\SDK\ICE\V20201109\ICE;
use AlibabaCloud\SDK\ICE\V20201109\Models\DeleteMediaInfosRequest;
use AlibabaCloud\SDK\ICE\V20201109\Models\RegisterMediaInfoRequest;
use AlibabaCloud\Tea\Exception\TeaUnableRetryError;
use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\AliyunICE\Media\DeleteRequest;
use App\Http\Requests\AliyunICE\Media\RegisterRequest;
use App\Http\Requests\AliyunICE\Media\SyncListRequest;
use App\Http\Requests\AliyunICE\Media\SyncRequest;
use App\Jobs\SyncMediaDetail;
use App\Jobs\SyncMediaList;
use App\Models\MediaInfo;
use Darabonba\OpenApi\Models\Config;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ReflectionException;

class MediaController extends ApiBaseController
{
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $mediaBasicInfo = $request->validated();

            $model = MediaInfo::query()
                ->where('user_id', $request->user()->id)
                ->where('client_token', $request->client_token)
                ->first();
            if (!$model) {
                $model            = new MediaInfo(['client_token' => $request->client_token]);
                $model->user_id   = $request->user()->id;
                $model->user_data = [
                    // 'notify_address' => $request->getSchemeAndHttpHost() . '/api/aliyun-ice/media/hook',
                    'notify_address' => $request->getSchemeAndHttpHost() . '/api/aliyun-ice/callback',
                    'user_id'        => $request->user()->id,
                    'client_token'   => $request->client_token,
                ];
            }
            if ($model->media_id && !$request->overwrite) {
                return $this->error(400, '已注册, 请勿重复注册');
            }
            $data = [
                'media_basic_info' => $mediaBasicInfo,
                'client_token'     => $request->client_token,
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
            // return $model->getDataForRegister();
            $clientRequest = new RegisterMediaInfoRequest($model->getDataForRegister());

            $response = $client->registerMediaInfo($clientRequest);
            if ($response->statusCode != 200) {
                return $this->error($response->statusCode, '操作失败');
            }
            $model->media_id = $response->body->mediaId;
            $model->save();
            SyncMediaDetail::dispatch(["client_token" => $model->client_token, "user_id" => $model->user_id])->delay(30);
            return $this->success($response->body->toMap());

        } catch (TeaUnableRetryError|ReflectionException $e) {
            return $this->error(500, $e->getMessage());
        }
    }

    // public function syncList(SyncListRequest $request)
    // {
    //     SyncMediaList::dispatch($request->user()->id, $request->validated() ?? []);
    //     return $this->success();
    // }

    public function delete(DeleteRequest $request): JsonResponse
    {
        try {
            $query = MediaInfo::query()->where('user_id', $request->user()->id);
            if ($request->id) {
                // $query->where('media_id', $request->media_id);
                if (is_array($request->id)) {
                    $query->whereIn('_id', $request->id);
                } else {
                    $query->where('_id', $request->id);
                }
            }
            $query->delete();
            return $this->success([]);
            if ($request->client_token) {
                $query->where('client_token', $request->client_token);
            }
            $model = $query->first();
            if (!$model) {
                return $this->error(404, '未找到媒体信息');
            }
            if (!$model->media_id) {
                return $this->error(404, '媒体信息未注册');
            }
            $credential              = new Credential([
                                                          'type'              => 'access_key',
                                                          'access_key_id'     => \config('aliyun.access_key_id'),
                                                          'access_key_secret' => \config('aliyun.access_key_secret'),
                                                      ]);
            $config                  = new Config([
                                                      'credential' => $credential,
                                                      'endpoint'   => config('aliyun.ice.default.endpoint'),
                                                  ]);
            $client                  = new ICE($config);
            $clientRequest           = new DeleteMediaInfosRequest();
            $clientRequest->mediaIds = $model->media_id;
            $response                = $client->deleteMediaInfos($clientRequest);
            if ($response->statusCode != 200) {
                return $this->error($response->statusCode, '操作失败');
            }
            return $this->success();
        } catch (TeaUnableRetryError|ReflectionException $e) {
            return $this->error(500, $e->getMessage());
        }
    }

    public function sync(SyncRequest $req): JsonResponse
    {
        SyncMediaDetail::dispatch([
                                      "client_token" => $req->client_token,
                                      "media_id"     => $req->media_id,
                                      "user_id"      => $req->user()->id,
                                  ]);
        return $this->success();
    }
}
