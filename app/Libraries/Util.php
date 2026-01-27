<?php
/**
 * @author    liuchunhua<448455556@qq.com>
 * @date      2021/4/8
 * @copyright Canton Univideo
 */

namespace App\Libraries;


use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class Util
{
    public static function exceptionContext(Exception $e): array
    {
        $d = [
            'message' => $e->getMessage(),
            'line'    => $e->getLine(),
            'file'    => $e->getFile(),
        ];

        if ($e instanceof QueryException) {
            $d['sql'] = $e->getSql();
        }

        return $d;
    }

    public static function filterEmails($lists, $blockLists): array
    {
        if (empty($blockLists)) {
            return $lists;
        }
        $tmp = [];
        foreach ($lists as $email) {
            if (in_array($email, $blockLists)) {
                continue;
            }
            $suffix = substr(strrchr($email, "@"), 0);
            if (in_array($suffix, $blockLists)) {
                continue;
            }

            $tmp[] = $email;
        }

        return $tmp;
    }

    public static function uuid($prefix): string
    {
        return $prefix . date('YmdHis') . mt_rand(100, 999) . mt_rand(0, 9) . mt_rand(10, 99);
    }

    public static function requestLog(Request $request, $level = 'debug', $errors = [])
    {
        $tmp = [
            'params'  => $request->all(),
            'errors'  => $errors,
            'headers' => Arr::only($request->headers->all(), ['authorization', 'accept']),
        ];
        Log::driver('request')->$level($request->getPathInfo(), $tmp);
    }
}
