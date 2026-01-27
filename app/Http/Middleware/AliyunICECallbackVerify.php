<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AliyunICECallbackVerify
{
    // 预设的回调 URL 和鉴权密钥
    private $callbackUrl           = '';
    private $authKey               = '';
    private $allowedTimeDifference = 300; // 5 minutes

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Log::channel('ice-callback')->info('ice callback:', [
            'headers' => $request->headers->all(),
        ]);

        $timestamp = $request->header('X-ICE-TIMESTAMP');
        $signature = $request->header('X-ICE-SIGNATURE');
        // 检查时间戳是否存在并且有效
        if (!$timestamp || !$this->isTimestampValid($timestamp)) {
            return response()->json(['error' => 'Invalid timestamp'], 403);
        }

        // 检查签名是否存在
        if (!$signature) {
            return response()->json(['error' => 'Signature missing'], 403);
        }
        $this->callbackUrl = $request->url();
        $this->authKey     = config('aliyun.ice.callback_key');
        // 计算签名并验证
        $computedSignature = $this->computeSignature($timestamp);
        // dd($computedSignature);
        if ($signature !== $computedSignature) {
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        return $next($request);
    }

    /**
     * 检查时间戳是否在允许的时间差范围内
     *
     * @param string $timestamp
     * @return bool
     */
    private function isTimestampValid($timestamp)
    {
        if (config('app.debug')) {
            return true;
        }
        $currentTimestamp = time();
        return abs($currentTimestamp - $timestamp) <= $this->allowedTimeDifference;
    }

    /**
     * 计算签名
     *
     * @param string $timestamp
     * @return string
     */
    private function computeSignature($timestamp)
    {
        $md5Content = "{$this->callbackUrl}|{$timestamp}|{$this->authKey}";
        // dd(md5($md5Content));
        return md5($md5Content);
    }
}
