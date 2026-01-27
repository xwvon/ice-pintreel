<?php

use App\Models\MailScheduleDetail;

return [
    'labels'  => [
        'MailScheduleDetail'   => 'MailScheduleDetail',
        'mail-schedule-detail' => 'MailScheduleDetail',
    ],
    'fields'  => [
        'email'           => '收件人',
        'user_id'         => 'user ID',
        'sid'             => '任务ID',
        'mid'             => 'email ID',
        'schedule_status' => '任务状态',
        'send_status'     => '发送状态',
        'mail_status'     => '邮件状态',
        'verify_status'   => '校验状态',
        'paid'            => '计费',
        'task_id'         => 'task_id',
        'result_desc'     => '发送结果',
        'report_sent'     => 'report_sent',
        'report_open'     => 'report_open',
        'sub_user'     => '子账户',
        'user'            => [
            'username' => '用户名',
        ],
        'schedule'        => [
            'name' => '任务名称',
        ],
    ],
    'options' => [
        'schedule_status' => MailScheduleDetail::SCHEDULE_STATUS_LISTS,
        'send_status'     => MailScheduleDetail::SEND_STATUS_LISTS,
        'mail_status'     => MailScheduleDetail::MAIL_STATUS_LISTS,
        'verify_status'   => MailScheduleDetail::VERIFY_STATUS_LISTS,
        'paid'            => MailScheduleDetail::PAID_LISTS,
    ],
];
