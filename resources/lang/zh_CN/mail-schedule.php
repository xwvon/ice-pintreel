<?php

use App\Models\MailSchedule;

return [
    'labels'  => [
        'MailSchedule'  => 'MailSchedule',
        'mail-schedule' => 'MailSchedule',
    ],
    'fields'  => [
        'sender'       => '发件人',
        'sender_name'  => '发件人',
        'name'         => '名称',
        'reply'        => '邮件回复地址',
        'mail_id'      => '邮件ID',
        'user_id'      => 'user ID',
        'total_cnt'    => '总数',
        'total_cash'   => '预计支出',
        'real_cash'    => '实际支出',
        'price'        => '价格',
        'score_code'   => 'score_code',
        'sku'          => 'sku',
        'finish_cnt'   => '完成',
        'failure_cnt'  => '失败',
        'processed_at' => '执行时间',
        'type'         => '任务类型',
        'status'       => '任务状态',
        'sub_user'     => '子账户',
        'user'         => [
            'username' => '用户名',
        ],
        'content'      => [
            'name' => '消息',
        ],
    ],
    'options' => [
        'status' => MailSchedule::STATUS_LISTS,
    ],
];
