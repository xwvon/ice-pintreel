<?php

namespace App;

use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Stream;
use Illuminate\Console\OutputStyle;
use Illuminate\Support\Str;

class Helper
{
    public static function orderNo($prefix, $length)
    {
        $str = $prefix;
        for ($i = 0; $i < $length; $i++) {
            $str .= mt_rand(0, 9);
        }

        return $str;
    }

    /**
     * @param int $n
     * @param OutputStyle|null $output
     * @return void
     */
    public static function sleep(int $n, OutputStyle $output = null)
    {
        for ($i = $n; $i > 0; $i--) {
            $output && $output->text("等待{$i}秒...");
            sleep(1);
        }
    }

    public static function arrayKeyCamelForAliyun(array $array): array
    {
        $newArray = [];
        foreach ($array as $key => $value) {
            $key = Str::camel($key);
            if (is_array($value)) {
                $newArray[$key] = json_encode(self::arrayKeyCamel($value));
            } else {
                $newArray[$key] = $value;
            }
        }

        return $newArray;
    }

    public static function arrayKeyCamel(array $array, $ucFirst = true): array
    {
        $newArray = [];
        foreach ($array as $key => $value) {
            $key = Str::camel($key);
            if ($ucFirst) {
                $key = ucfirst($key);
            }
            if (is_array($value)) {
                $newArray[$key] = self::arrayKeyCamel($value, $ucFirst);
            } else {
                $newArray[$key] = $value;
            }
        }

        return $newArray;
    }

    public static function arrayKeySnake(array $array, $delimiter = '_'): array
    {
        $newArray = [];
        foreach ($array as $key => $value) {
            // 连续多个大写字母转为小写, 第一个字母大写, 如 'URL' => '_url'
            $key = preg_replace_callback('/([A-Z]{2,})/', function ($matches) {
                return ucfirst(strtolower($matches[0]));
            },                           $key);
            $key = Str::snake($key, $delimiter);
            if (is_array($value)) {
                $newArray[$key] = self::arrayKeySnake($value, $delimiter);
            } else {
                $newArray[$key] = $value;
            }
        }
        return $newArray;
    }

    /**
     * @param $url
     * @param $savePath
     * @param string $newFileName
     * @param int $timeout
     * @return bool
     */
    public static function downloadFile($url, $savePath, string $newFileName, int $timeout = 10)
    {
        try {
            if (!file_exists($savePath) || !is_dir($savePath)) {
                mkdir($savePath, 755, true);
            }
            $resources = fopen($savePath . '/' . $newFileName, 'w');
            $client    = new Client();
            $client->request('GET', $url, ['sink' => $resources, 'timeout' => $timeout]);
            if (is_resource($resources)) {
                fclose($resources);
            }
            return true;
        } catch (GuzzleException $e) {

        }
        return false;
    }

    public static function uploadFileWithFormData($url, $filePathLists, $fieldName, $formData = [])
    {
        // 创建 GuzzleHttp 客户端
        $client = new Client();

        // 创建请求实体
        $request = new Request('POST', $url);

        // 创建 multipart/form-data 内容
        $multipart = [];

        foreach ($filePathLists as $filePath) {
            // 添加文件字段
            $multipart[] = [
                'name'     => $fieldName,
                'contents' => fopen($filePath, 'r'),
                'filename' => basename($filePath),
            ];
        }

        // 添加其他字段
        foreach ($formData as $key => $value) {
            $multipart[] = [
                'name'     => $key,
                'contents' => $value,
            ];
        }

        // 设置请求体为 multipart/form-data
        $request = $request->withHeader('Content-Type', 'multipart/form-data');
        $request = $request->withBody(new Stream(fopen('php://temp', 'r+')));

        // 创建 multipart/form-data 流并写入请求体
        $boundary = uniqid();
//        $stream = \GuzzleHttp\Psr7\Utils::multipartStream($multipart, $boundary);
        $stream  = new MultipartStream($multipart);
        $request = $request->withBody($stream);
        $request = $request->withHeader('Content-Length', $stream->getSize());

        // 发送请求并获取响应
        $response = $client->send($request);

        // 返回响应内容
        return $response->getBody()->getContents();
    }

    public static function bubbleSortByKey(&$arr, $key, $order = SORT_ASC)
    {
        $n = count($arr);
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n - 1 - $i; $j++) {
                $shouldSwap = ($order === SORT_ASC && $arr[$j][$key] > $arr[$j + 1][$key])
                    || ($order === SORT_DESC && $arr[$j][$key] < $arr[$j + 1][$key]);
                if ($shouldSwap) {
                    $temp        = $arr[$j];
                    $arr[$j]     = $arr[$j + 1];
                    $arr[$j + 1] = $temp;
                }
            }
        }
    }

    /**
     * @param $arr
     * @param $keys
     * @param Closure|null $fun
     * @return array
     */
    public static function sortByKeysOrder(&$arr, $keys, Closure $fun = null): array
    {
        $newArr = [];
        foreach ($keys as $key) {
            if (isset($arr[$key])) {
                $fun !== null && $fun($arr[$key]);
                $newArr[$key] = $arr[$key];
                unset($arr[$key]);
            }
        }
        return $newArr + $arr;
    }

    public static function send_mail()
    {
        $url = 'http://api2.sendcloud.net/api/mail/send';

        $API_USER = '...';
        $API_KEY  = '...';
        $param    = [
            'apiUser'     => $API_USER, # 使用api_user和api_key进行验证
            'apiKey'      => $API_KEY,
            'from'        => 'sendcloud@sendcloud.org', # 发信人，用正确邮件地址替代
            'fromName'    => 'SendCloud',
            'to'          => 'test@ifaxin.com', # 收件人地址，用正确邮件地址替代，多个地址用';'分隔
            'subject'     => 'Sendcloud php webapi with attachment example',
            'html'        => '欢迎使用SendCloud',
            'respEmailId' => 'true',
        ];

        $file    = "./test.txt"; #你的附件路径1
        $handle  = fopen($file, 'rb');
        $content = fread($handle, filesize($file));


        $file2    = "./test2.txt"; #你的附件路径2
        $handle2  = fopen($file2, 'rb');
        $content2 = fread($handle2, filesize($file2));


        $eol  = "\r\n";
        $data = '';

        $mime_boundary = md5(time());

        // 配置参数
        foreach ($param as $key => $value) {
            $data .= '--' . $mime_boundary . $eol;
            $data .= 'Content-Disposition: form-data; ';
            $data .= "name=" . $key . $eol . $eol;
            $data .= $value . $eol;
        }

        // 配置文件
        $data .= '--' . $mime_boundary . $eol;
        $data .= 'Content-Disposition: form-data; name="attachments"; filename="filename.txt"' . $eol;
        $data .= 'Content-Type: text/plain' . $eol;
        $data .= 'Content-Transfer-Encoding: binary' . $eol . $eol;
        $data .= $content . $eol;

        $data .= '--' . $mime_boundary . $eol;
        $data .= 'Content-Disposition: form-data; name="attachments"; filename="filename2.txt"' . $eol;
        $data .= 'Content-Type: text/plain' . $eol;
        $data .= 'Content-Transfer-Encoding: binary' . $eol . $eol;
        $data .= $content2 . $eol;

        $data .= "--" . $mime_boundary . "--" . $eol . $eol;

        $options = [
            'http' => [
                'method'  => 'POST',
                'header'  => 'Content-Type: multipart/form-data;boundary=' . $mime_boundary . $eol,
                'content' => $data,
            ],
        ];
        $context = stream_context_create($options);
        $result  = file_get_contents($url, FILE_TEXT, $context);

        return $result;
        fclose($handle);
        fclose($handle2);
    }
}
