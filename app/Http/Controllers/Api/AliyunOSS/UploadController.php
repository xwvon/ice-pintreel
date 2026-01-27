<?php

namespace App\Http\Controllers\Api\AliyunOSS;

use App\Http\Controllers\Controller;
use App\Http\Requests\AliyunOSS\SignUrlRequest;
use OSS\Core\OssException;
use OSS\OssClient;

class UploadController extends Controller
{
    public function signUrl(SignUrlRequest $request)
    {
        $config          = \config('aliyun');
        $accessKeyId     = $config["access_key_id"];
        $accessKeySecret = $config["access_key_secret"];
        $endpoint        = $request->endpoint ?? $config["oss"]["default"]["endpoint"];
        $bucket          = $request->bucket ?? $config["oss"]["default"]["bucket"];
        $path = $request->path;
        try {
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            $url       = $ossClient->signUrl(
                $bucket,
                $path,
                $request->expires ?: 3600,
                $request->http_method ?: OssClient::OSS_HTTP_PUT
            );
            return $this->success([
                                      'url' => $url,
                                  ]);
        } catch (OssException $e) {
            return $this->error(0, $e->getMessage());
        }
    }


}
