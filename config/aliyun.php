<?php
return [
    'access_key_id' => env('ALIYUN_ACCESS_KEY_ID'),
    'access_key_secret' => env('ALIYUN_ACCESS_KEY_SECRET'),
    'oss' => [
        'default' => [
            'endpoint' => env('ALIYUN_OSS_ENDPOINT', 'oss-cn-shanghai.aliyuncs.com'),
            'bucket' => env('ALIYUN_OSS_BUCKET', 'test-ice-shanghai'),
        ],
    ],
    'ice' => [
        'callback_key' => env('ALIYUN_ICE_CALLBACK_KEY', ''),
        'default' => [
            'endpoint' => env('ALIYUN_ICE_ENDPOINT', 'ice.cn-shanghai.aliyuncs.com'),
        ],
    ],
];
