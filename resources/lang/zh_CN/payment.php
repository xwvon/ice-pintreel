<?php
return [
    'labels' => [
        'Payment' => 'Payment',
        'payment' => 'Payment',
    ],
    'fields' => [
        'appid' => 'appid',
        'subject' => '订单标题',
        'buyer_id' => '买家ID',
        'trade_no' => '支付宝交易号',
        'out_trade_no' => '商户订单号',
        'trade_status' => '交易状态',
        'receipt_amount' => '实收金额',
        'invoice_amount' => '开票金额',
        'buyer_pay_amount' => '付款金额',
        'total_amount' => '订单金额',
        'buyer_logon_id' => '买家支付宝账号',
        'event_target' => '触发事件',
        'gmt_payment' => '付款时间',
    ],
    'options' => [
        'trade_status' => [
            'WAIT_BUYER_PAY' => '待付款',
            'TRADE_CLOSED' => '交易关闭',
            'TRADE_SUCCESS' => '交易成功',
            'TRADE_FINISHED' => '交易完成',
        ],
    ],
];
