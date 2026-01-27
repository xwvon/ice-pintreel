<?php
return [
    'labels' => [
        'UserWalletLog' => 'UserWalletLog',
        'user-wallet-log' => 'UserWalletLog',
    ],
    'fields' => [
        'user_id' => 'users.id',
        'currency' => '币种',
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
            '待处理',
            '处理中',
            '完成',
            '失败'
        ],
    ],
];
