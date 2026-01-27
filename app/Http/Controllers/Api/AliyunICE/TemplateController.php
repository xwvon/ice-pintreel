<?php

namespace App\Http\Controllers\Api\AliyunICE;

use AlibabaCloud\Credentials\Credential;
use AlibabaCloud\SDK\ICE\V20201109\ICE;
use AlibabaCloud\SDK\ICE\V20201109\Models\AddTemplateRequest;
use AlibabaCloud\SDK\ICE\V20201109\Models\ListTemplatesRequest;
use AlibabaCloud\SDK\ICE\V20201109\Models\GetTemplateRequest;
use AlibabaCloud\Tea\Exception\TeaUnableRetryError;
use App\Helper;
use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\AliyunICE\Template\CreateRequest;
use App\Http\Requests\AliyunICE\Template\SyncRequest;
use App\Models\Template;
use Darabonba\OpenApi\Models\Config;
use Illuminate\Http\JsonResponse;
use ReflectionException;
use Illuminate\Http\Request;

class TemplateController extends ApiBaseController
{

    public function index(Request $request): JsonResponse
    {
        try {
            // $params         = $request->validated();
            // $params = $request->all();
            // $params = Helper::arrayKeySnake($params);
            // dd(json_encode($params, JSON_UNESCAPED_UNICODE));
            // $model          = new Template($params);
            // $model->user_id = $request->user()->id;
            $data = Template::whereUserId(auth()->user()->getAuthIdentifier())->get(['id', 'template_id', 'name', 'type', 'config', 'cover_url', 'preview_media', 'status', 'created_at'])->toArray();
            return $this->success($data);
            $credential     = new Credential([
                                                 'type'              => 'access_key',
                                                 'access_key_id'     => config('aliyun.access_key_id'),
                                                 'access_key_secret' => config('aliyun.access_key_secret'),
                                             ]);
            $config         = new Config([
                                             'credential' => $credential,
                                             'endpoint'   => config('aliyun.ice.default.endpoint'),
                                         ]);
            $client         = new ICE($config);
            $clientRequest  = new ListTemplatesRequest();
            $response       = $client->listTemplates($clientRequest);
            if ($response->statusCode != 200) {
                return $this->error($response->statusCode, '操作失败');
            }
            
            return $this->success($response->body->toMap());
        } catch (TeaUnableRetryError|ReflectionException $e) {
            return $this->error(500, $e->getMessage());
        }
    }
    public function create(CreateRequest $request): JsonResponse
    {
        try {
            // $params         = $request->validated();
            $params = $request->all();
            $params = Helper::arrayKeySnake($params);
            // dd(json_encode($params, JSON_UNESCAPED_UNICODE));
            $model          = new Template($params);
            $model->user_id = $request->user()->id;
            $credential     = new Credential([
                                                 'type'              => 'access_key',
                                                 'access_key_id'     => config('aliyun.access_key_id'),
                                                 'access_key_secret' => config('aliyun.access_key_secret'),
                                             ]);
            $config         = new Config([
                                             'credential' => $credential,
                                             'endpoint'   => config('aliyun.ice.default.endpoint'),
                                         ]);
            $client         = new ICE($config);
            $clientRequest  = new AddTemplateRequest($model->getDataForAddTemplate());
            $response       = $client->addTemplate($clientRequest);
            if ($response->statusCode != 200) {
                return $this->error($response->statusCode, '操作失败');
            }
            $data = $response->body->template->toMap();
            $data = Helper::arrayKeySnake($data);
            $model->forceFill($data);
            $model->save();
            return $this->success($data);
        } catch (TeaUnableRetryError|ReflectionException $e) {
            return $this->error(500, $e->getMessage());
        }
    }

    public function sync(SyncRequest $request): JsonResponse
    {
        try {
            $model = Template::query()
                ->where('user_id', $request->user()->id)
                ->where('template_id', $request->template_id)
                ->first();
            if (!$model) {
                $model              = new Template();
                $model->user_id     = $request->user()->id;
                $model->template_id = $request->template_id;
                // return $this->error(404, '模板不存在');
            }
            $credential                = new Credential([
                                                            'type'              => 'access_key',
                                                            'access_key_id'     => config('aliyun.access_key_id'),
                                                            'access_key_secret' => config('aliyun.access_key_secret'),
                                                        ]);
            $config                    = new Config([
                                                        'credential' => $credential,
                                                        'endpoint'   => config('aliyun.ice.default.endpoint'),
                                                    ]);
            $client                    = new ICE($config);
            $clientRequest             = new GetTemplateRequest();
            $clientRequest->templateId = $model->template_id;
            $response                  = $client->getTemplate($clientRequest);
            if ($response->statusCode != 200) {
                return $this->error($response->statusCode, '操作失败');
            }
            $data = $response->body->template->toMap();
            $data = Helper::arrayKeySnake($data);
            $model->forceFill($data);
            $model->save();
            return $this->success($data);
        } catch (TeaUnableRetryError|ReflectionException $e) {
            return $this->error(500, $e->getMessage());
        }
    }
}
