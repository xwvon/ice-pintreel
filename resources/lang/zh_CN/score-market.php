<?php

use App\Models\ScoreMarket;
use App\Models\ScoreType;

return [
    'labels'  => [
        'ScoreMarket'  => 'ScoreMarket',
        'score-market' => 'ScoreMarket',
    ],
    'fields'  => [
        'name'          => '名称',
        'score_code'    => '积分编码',
        'market_code'   => '市场编码',
        'amount'        => '数额',
        'type'          => '类型',
        'status'        => '状态',
        'zero_clear'    => '清零',
        'start_time'    => '开始时间',
        'end_time'      => '结束时间',
        'user_includes' => '包含用户',
        'user_excepts'  => '排除用户',
        'type_user'     => '用户列表',

        'score' => [
            'name' => '积分',
        ],
    ],
    'options' => [
        'type'      => ScoreType::INIT_TYPE_LISTS,
        'type_user' => ScoreMarket::userTypeLists(),
    ],
];
