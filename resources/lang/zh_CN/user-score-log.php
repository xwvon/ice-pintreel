<?php
return [
    'labels'  => [
        'UserScoreLog'   => 'UserScoreLog',
        'user-score-log' => 'UserScoreLog',
    ],
    'fields'  => [
        'user_id'       => '用户ID',
        'score_code'    => '类型',
        'order_no'      => '订单号',
        'amount'        => '数额',
        'before_amount' => '变动前数额',
        'status'        => '状态',
        'mark'          => '备注',
        'user'          => [
            'username' => '用户名',
        ],
        'account' => '账户类型',
        'income' => '类型',
    ],
    'options' => [
        'status'  => [
            '',
            '待处理',
            '处理中',
            '完成',
            '失败',
        ],
        'account' => [
            '账户余额',
            '冻结余额',
        ],
        'income'  => [
            '扣除',
            '增加',
        ],
    ],
];
