<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileUpload\SimpleRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use OSS\Core\OssException;
use OSS\OssClient;
use App\Models\UserFile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MediaInfo;
use App\Jobs\RegisterMediaInfo;
use Illuminate\Support\Facades\Redis;
use AlibabaCloud\SDK\Sts\V20150401\Sts;
use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Sts\V20150401\Models\AssumeRoleRequest;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use Illuminate\Support\Facades\Log;

class FileUploadController extends Controller
{
    /**
     * 上传文件
     *
     * @param SimpleRequest $request
     * @return JsonResponse
     */
    public function simple(SimpleRequest $request)
    {
        // Validate uploaded file
        // limit file size to 10 MB

        // Get uploaded file
        $file = $request->file('file');
        
        // if (auth()->user()->username == "pintreel_wg") {
        //     dd(auth()->user()->username);
        // }

        // Generate unique file name
        // $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $filename = auth()->user()->username . '/' . $file->getClientOriginalName();

        $disk = $request->disk;

        $path = 'uploads/' . date('Ymd');
        // Store file to disk
        // Storage::disk($disk)->putFileAs($path, $file, $filename);
        $config          = \config('aliyun');
        $accessKeyId     = $config["access_key_id"];
        $accessKeySecret = $config["access_key_secret"];
        $endpoint        = $request->endpoint ?? $config["oss"]["default"]["endpoint"];
        $bucket          = $request->bucket ?? $config["oss"]["default"]["bucket"];
        try {
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            $data = $ossClient->uploadFile($bucket, $filename, $file->getRealPath());
            if ($data) {
                $userfile = UserFile::create([
                    'user_id' => $request->user()->id,
                    'name'    => $filename,
                    'disk'    => 'oss',
                    'path'    => $data['info']['url'],
                    'type'    => $file->getMimeType(),
                    'ext'     => $file->getClientOriginalExtension(),
                    'size'    => $file->getSize(),
                    'mime'    => $file->getMimeType(),
                    'labels'  => [],
                    'payload' => json_encode($data)
                ]);
                RegisterMediaInfo::dispatch($userfile, Str::uuid()->toString());
            }
        } catch (OssException $e) {
            return $this->error(0, $e->getMessage());
        }

        // $data = [
        //     'path' => $path . '/' . $filename,
        //     'url'  => Storage::disk($disk)->url($path . '/' . $filename),
        // ];
        // if ($disk === 'local') {
        //     unset($data['url']);
        // }
        return $this->success(['url' => $data['info']['url']]);
    }
    
    public function index(Request $request): JsonResponse
    {
        $data = MediaInfo::whereUserId(auth()->user()->getAuthIdentifier())->latest()->select(['media_id', 'media_basic_info.input_url'])->paginate($request->perpage ?? 10);
        $medias = $data->map(function ($media) {
            
            if ($media->media_id) {
                $bucket_domain = env('ALIYUN_OSS_BUCKET') . '.' .  env('ALIYUN_REGION_ID') . '.aliyuncs.com/';
                $media->url = $this->getUrl(Str::after($media->media_basic_info['input_url'], $bucket_domain), $media->media_id);
            }
            unset($media->media_basic_info);
            return $media;
        })->toArray();
        return $this->success(['medias' => $medias, 'total' => $data->total(), 'perpage' => $data->perPage(), 'next_page' => $data->nextPageUrl()]);
    }
    
    private function getUrl($path, $mediaId)
    {
        $config          = \config('aliyun');
        $accessKeyId     = $config["access_key_id"];
        $accessKeySecret = $config["access_key_secret"];
        $endpoint        = $request->endpoint ?? $config["oss"]["default"]["endpoint"];
        $bucket          = $request->bucket ?? $config["oss"]["default"]["bucket"];
        try {
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            $url       = $ossClient->signUrl(
                $bucket,
                $path,
                3600,
                OssClient::OSS_HTTP_GET
            );
            // Redis::set($mediaId, $url, 3600);
            Redis::set($mediaId, $url, 'EX', 3600);
            return $url;
        } catch (OssException $e) {
            Log::info($e->getMessage());
            return '';
        }
    }
    
    /** upload video to aliyun oss */
    public function uploadVideoToAliyunOss(Request $request): JsonResponse
    {
        $request->validate([
            'video' => 'required|array',
            'video.*' => 'required|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:204800',
        ]);
        $file = $request->file('video');
        if (is_array($file)) {
            $urls = [];
            // async upload video to aliyun oss
            foreach ($file as $f) {
                $filename = 'video_' . time() . '.' . $f->getClientOriginalExtension();
                $client = new OSSClient(env('ALIYUN_VIDEO_ACCESS_KEY_ID'), env('ALIYUN_VIDEO_ACCESS_KEY_SECRET'), 'oss-cn-beijing.aliyuncs.com');
                $data = $client->uploadFile(env('ALIYUN_VIDEO_BUCKET'),  $filename, $f->getRealPath());
                $url       = $client->signUrl(
                    env('ALIYUN_VIDEO_BUCKET'),
                    $filename,
                    3600,
                    OssClient::OSS_HTTP_GET
                );
                $urls[] = $url;
            }
            return $this->success(['urls' => $urls]);
        }
        $filename = 'video_' . time() . '.' . $file->getClientOriginalExtension();
        // $file->move(public_path('videos'), $filename);
        $client = new OSSClient(env('ALIYUN_VIDEO_ACCESS_KEY_ID'), env('ALIYUN_VIDEO_ACCESS_KEY_SECRET'), 'oss-cn-beijing.aliyuncs.com');
  
        $data = $client->uploadFile(env('ALIYUN_VIDEO_BUCKET'),  $filename, $file->getRealPath());
        $url       = $client->signUrl(
            env('ALIYUN_VIDEO_BUCKET'),
            $filename,
            3600,
            OssClient::OSS_HTTP_GET
        );
        return $this->success(['url' => $url]);
    }
    
    public function credential(Request $request)
    {
        // 工程代码泄露可能会导致 AccessKey 泄露，并威胁账号下所有资源的安全性。以下代码示例仅供参考。
        // 建议使用更安全的 STS 方式，更多鉴权访问方式请参见：https://help.aliyun.com/document_detail/311677.html。
        $config = new Config([
            // 必填，请确保代码运行环境设置了环境变量 ALIBABA_CLOUD_ACCESS_KEY_ID。
            "accessKeyId" => env('ALIYUN_STS_ACCESS_KEY_ID'),
            // 必填，请确保代码运行环境设置了环境变量 ALIBABA_CLOUD_ACCESS_KEY_SECRET。
            "accessKeySecret" => env('ALIYUN_STS_ACCESS_KEY_SECRET'),
        ]);
        // Endpoint 请参考 https://api.aliyun.com/product/Sts
        $config->endpoint = "sts.us-east-1.aliyuncs.com";
        $client = new Sts($config);
        $assumeRoleRequest = new AssumeRoleRequest([
            // "roleArn" => "acs:ram::1074210416593145:role/aliyunicedefaultrole",
            "roleArn" => env('ALIYUN_ROLE_ARN'),
            "roleSessionName" => env('ALIYUN_ROLE_SESSION_NAME')
        ]);
        $runtime = new RuntimeOptions([]);
        $result = $client->assumeRoleWithOptions($assumeRoleRequest, $runtime);
        return $this->success($result->toMap()['body']['Credentials']);
        // $body = json_decode($result->getName('Body'));
        // return $this->success($body['Credentials']);
    }
}
