<?php
return [
    'labels' => [
        'UserScoreLog' => 'UserScoreLog',
        'user-score-log' => 'UserScoreLog',
    ],
    'fields' => [
        'user_id' => 'users.id',
        'score_code' => '类型',
        'order_no' => '订单号',
        'amount' => '数额',
        'before_amount' => '变动前数额',
        'status' => '状态',
        'mark' => '备注',
        'user' => [
            'username' => '用户名'
        ]
    ],
    'options' => [
        'status' => [
            '',
            'pending',
            'processing',
            'finish',
            'failure'
        ],
    ],
];
