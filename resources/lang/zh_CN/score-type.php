<?php

use App\Models\ScoreType;

return [
    'labels'  => [
        'ScoreType'  => 'ScoreType',
        'score-type' => 'ScoreType',
    ],
    'fields'  => [
        'name'        => '名称',
        'code'        => '编码',
        'init_type'   => '初始化方式',
        'init_amount' => '初始值',
        'status'      => '状态',
        'deposit'      => '充值',
    ],
    'options' => [
        'init_type' => ScoreType::INIT_TYPE_LISTS,
    ],
];
