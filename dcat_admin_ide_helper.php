<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection cnt
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection failure_at
     * @property Grid\Column|Collection code2
     * @property Grid\Column|Collection code3
     * @property Grid\Column|Collection country_code
     * @property Grid\Column|Collection amount
     * @property Grid\Column|Collection code
     * @property Grid\Column|Collection params
     * @property Grid\Column|Collection period
     * @property Grid\Column|Collection rule
     * @property Grid\Column|Collection sku
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection bak_table
     * @property Grid\Column|Collection date
     * @property Grid\Column|Collection table_name
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection uuid
     * @property Grid\Column|Collection city
     * @property Grid\Column|Collection district
     * @property Grid\Column|Collection ip_end
     * @property Grid\Column|Collection ip_start
     * @property Grid\Column|Collection lat
     * @property Grid\Column|Collection lng
     * @property Grid\Column|Collection nation
     * @property Grid\Column|Collection nation_code
     * @property Grid\Column|Collection province
     * @property Grid\Column|Collection timezone
     * @property Grid\Column|Collection zip_code
     * @property Grid\Column|Collection attachments
     * @property Grid\Column|Collection content
     * @property Grid\Column|Collection sub_user
     * @property Grid\Column|Collection subject
     * @property Grid\Column|Collection adcode
     * @property Grid\Column|Collection detail_id
     * @property Grid\Column|Collection ipv4
     * @property Grid\Column|Collection nation_en
     * @property Grid\Column|Collection sid
     * @property Grid\Column|Collection user_agent
     * @property Grid\Column|Collection bno
     * @property Grid\Column|Collection del
     * @property Grid\Column|Collection failure_cnt
     * @property Grid\Column|Collection finish_cnt
     * @property Grid\Column|Collection free_cnt
     * @property Grid\Column|Collection mail_id
     * @property Grid\Column|Collection paid_cnt
     * @property Grid\Column|Collection processed_at
     * @property Grid\Column|Collection real_cash
     * @property Grid\Column|Collection reply
     * @property Grid\Column|Collection score_code
     * @property Grid\Column|Collection sender
     * @property Grid\Column|Collection sender_name
     * @property Grid\Column|Collection settle
     * @property Grid\Column|Collection total_cash
     * @property Grid\Column|Collection total_cnt
     * @property Grid\Column|Collection mid
     * @property Grid\Column|Collection is_free
     * @property Grid\Column|Collection mail_status
     * @property Grid\Column|Collection paid
     * @property Grid\Column|Collection report_sent
     * @property Grid\Column|Collection result_desc
     * @property Grid\Column|Collection schedule_status
     * @property Grid\Column|Collection send_status
     * @property Grid\Column|Collection task_id
     * @property Grid\Column|Collection verify_status
     * @property Grid\Column|Collection mail_uid
     * @property Grid\Column|Collection query_method
     * @property Grid\Column|Collection api
     * @property Grid\Column|Collection provider
     * @property Grid\Column|Collection send_domain
     * @property Grid\Column|Collection send_mail
     * @property Grid\Column|Collection user
     * @property Grid\Column|Collection weight
     * @property Grid\Column|Collection reject
     * @property Grid\Column|Collection report_spam
     * @property Grid\Column|Collection unsubscribe
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection appid
     * @property Grid\Column|Collection buyer_id
     * @property Grid\Column|Collection buyer_logon_id
     * @property Grid\Column|Collection buyer_pay_amount
     * @property Grid\Column|Collection currency
     * @property Grid\Column|Collection event_target
     * @property Grid\Column|Collection gmt_payment
     * @property Grid\Column|Collection invoice_amount
     * @property Grid\Column|Collection notify_raw
     * @property Grid\Column|Collection out_trade_no
     * @property Grid\Column|Collection receipt_amount
     * @property Grid\Column|Collection total_amount
     * @property Grid\Column|Collection trade_no
     * @property Grid\Column|Collection trade_status
     * @property Grid\Column|Collection data
     * @property Grid\Column|Collection order_id
     * @property Grid\Column|Collection abilities
     * @property Grid\Column|Collection last_used_at
     * @property Grid\Column|Collection tokenable_id
     * @property Grid\Column|Collection tokenable_type
     * @property Grid\Column|Collection market_code
     * @property Grid\Column|Collection end_time
     * @property Grid\Column|Collection start_time
     * @property Grid\Column|Collection type_user
     * @property Grid\Column|Collection zero_clear
     * @property Grid\Column|Collection price
     * @property Grid\Column|Collection deposit
     * @property Grid\Column|Collection init_amount
     * @property Grid\Column|Collection init_type
     * @property Grid\Column|Collection secret
     * @property Grid\Column|Collection chatgpt
     * @property Grid\Column|Collection frozen_amount
     * @property Grid\Column|Collection init_date
     * @property Grid\Column|Collection init_status
     * @property Grid\Column|Collection account
     * @property Grid\Column|Collection before_amount
     * @property Grid\Column|Collection income
     * @property Grid\Column|Collection mark
     * @property Grid\Column|Collection order_no
     * @property Grid\Column|Collection cash_max
     * @property Grid\Column|Collection cash_min
     * @property Grid\Column|Collection change_rate
     *
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection cnt(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection failure_at(string $label = null)
     * @method Grid\Column|Collection code2(string $label = null)
     * @method Grid\Column|Collection code3(string $label = null)
     * @method Grid\Column|Collection country_code(string $label = null)
     * @method Grid\Column|Collection amount(string $label = null)
     * @method Grid\Column|Collection code(string $label = null)
     * @method Grid\Column|Collection params(string $label = null)
     * @method Grid\Column|Collection period(string $label = null)
     * @method Grid\Column|Collection rule(string $label = null)
     * @method Grid\Column|Collection sku(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection bak_table(string $label = null)
     * @method Grid\Column|Collection date(string $label = null)
     * @method Grid\Column|Collection table_name(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection uuid(string $label = null)
     * @method Grid\Column|Collection city(string $label = null)
     * @method Grid\Column|Collection district(string $label = null)
     * @method Grid\Column|Collection ip_end(string $label = null)
     * @method Grid\Column|Collection ip_start(string $label = null)
     * @method Grid\Column|Collection lat(string $label = null)
     * @method Grid\Column|Collection lng(string $label = null)
     * @method Grid\Column|Collection nation(string $label = null)
     * @method Grid\Column|Collection nation_code(string $label = null)
     * @method Grid\Column|Collection province(string $label = null)
     * @method Grid\Column|Collection timezone(string $label = null)
     * @method Grid\Column|Collection zip_code(string $label = null)
     * @method Grid\Column|Collection attachments(string $label = null)
     * @method Grid\Column|Collection content(string $label = null)
     * @method Grid\Column|Collection sub_user(string $label = null)
     * @method Grid\Column|Collection subject(string $label = null)
     * @method Grid\Column|Collection adcode(string $label = null)
     * @method Grid\Column|Collection detail_id(string $label = null)
     * @method Grid\Column|Collection ipv4(string $label = null)
     * @method Grid\Column|Collection nation_en(string $label = null)
     * @method Grid\Column|Collection sid(string $label = null)
     * @method Grid\Column|Collection user_agent(string $label = null)
     * @method Grid\Column|Collection bno(string $label = null)
     * @method Grid\Column|Collection del(string $label = null)
     * @method Grid\Column|Collection failure_cnt(string $label = null)
     * @method Grid\Column|Collection finish_cnt(string $label = null)
     * @method Grid\Column|Collection free_cnt(string $label = null)
     * @method Grid\Column|Collection mail_id(string $label = null)
     * @method Grid\Column|Collection paid_cnt(string $label = null)
     * @method Grid\Column|Collection processed_at(string $label = null)
     * @method Grid\Column|Collection real_cash(string $label = null)
     * @method Grid\Column|Collection reply(string $label = null)
     * @method Grid\Column|Collection score_code(string $label = null)
     * @method Grid\Column|Collection sender(string $label = null)
     * @method Grid\Column|Collection sender_name(string $label = null)
     * @method Grid\Column|Collection settle(string $label = null)
     * @method Grid\Column|Collection total_cash(string $label = null)
     * @method Grid\Column|Collection total_cnt(string $label = null)
     * @method Grid\Column|Collection mid(string $label = null)
     * @method Grid\Column|Collection is_free(string $label = null)
     * @method Grid\Column|Collection mail_status(string $label = null)
     * @method Grid\Column|Collection paid(string $label = null)
     * @method Grid\Column|Collection report_sent(string $label = null)
     * @method Grid\Column|Collection result_desc(string $label = null)
     * @method Grid\Column|Collection schedule_status(string $label = null)
     * @method Grid\Column|Collection send_status(string $label = null)
     * @method Grid\Column|Collection task_id(string $label = null)
     * @method Grid\Column|Collection verify_status(string $label = null)
     * @method Grid\Column|Collection mail_uid(string $label = null)
     * @method Grid\Column|Collection query_method(string $label = null)
     * @method Grid\Column|Collection api(string $label = null)
     * @method Grid\Column|Collection provider(string $label = null)
     * @method Grid\Column|Collection send_domain(string $label = null)
     * @method Grid\Column|Collection send_mail(string $label = null)
     * @method Grid\Column|Collection user(string $label = null)
     * @method Grid\Column|Collection weight(string $label = null)
     * @method Grid\Column|Collection reject(string $label = null)
     * @method Grid\Column|Collection report_spam(string $label = null)
     * @method Grid\Column|Collection unsubscribe(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection appid(string $label = null)
     * @method Grid\Column|Collection buyer_id(string $label = null)
     * @method Grid\Column|Collection buyer_logon_id(string $label = null)
     * @method Grid\Column|Collection buyer_pay_amount(string $label = null)
     * @method Grid\Column|Collection currency(string $label = null)
     * @method Grid\Column|Collection event_target(string $label = null)
     * @method Grid\Column|Collection gmt_payment(string $label = null)
     * @method Grid\Column|Collection invoice_amount(string $label = null)
     * @method Grid\Column|Collection notify_raw(string $label = null)
     * @method Grid\Column|Collection out_trade_no(string $label = null)
     * @method Grid\Column|Collection receipt_amount(string $label = null)
     * @method Grid\Column|Collection total_amount(string $label = null)
     * @method Grid\Column|Collection trade_no(string $label = null)
     * @method Grid\Column|Collection trade_status(string $label = null)
     * @method Grid\Column|Collection data(string $label = null)
     * @method Grid\Column|Collection order_id(string $label = null)
     * @method Grid\Column|Collection abilities(string $label = null)
     * @method Grid\Column|Collection last_used_at(string $label = null)
     * @method Grid\Column|Collection tokenable_id(string $label = null)
     * @method Grid\Column|Collection tokenable_type(string $label = null)
     * @method Grid\Column|Collection market_code(string $label = null)
     * @method Grid\Column|Collection end_time(string $label = null)
     * @method Grid\Column|Collection start_time(string $label = null)
     * @method Grid\Column|Collection type_user(string $label = null)
     * @method Grid\Column|Collection zero_clear(string $label = null)
     * @method Grid\Column|Collection price(string $label = null)
     * @method Grid\Column|Collection deposit(string $label = null)
     * @method Grid\Column|Collection init_amount(string $label = null)
     * @method Grid\Column|Collection init_type(string $label = null)
     * @method Grid\Column|Collection secret(string $label = null)
     * @method Grid\Column|Collection chatgpt(string $label = null)
     * @method Grid\Column|Collection frozen_amount(string $label = null)
     * @method Grid\Column|Collection init_date(string $label = null)
     * @method Grid\Column|Collection init_status(string $label = null)
     * @method Grid\Column|Collection account(string $label = null)
     * @method Grid\Column|Collection before_amount(string $label = null)
     * @method Grid\Column|Collection income(string $label = null)
     * @method Grid\Column|Collection mark(string $label = null)
     * @method Grid\Column|Collection order_no(string $label = null)
     * @method Grid\Column|Collection cash_max(string $label = null)
     * @method Grid\Column|Collection cash_min(string $label = null)
     * @method Grid\Column|Collection change_rate(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection type
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection version
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection order
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection password
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection username
     * @property Show\Field|Collection cnt
     * @property Show\Field|Collection email
     * @property Show\Field|Collection failure_at
     * @property Show\Field|Collection code2
     * @property Show\Field|Collection code3
     * @property Show\Field|Collection country_code
     * @property Show\Field|Collection amount
     * @property Show\Field|Collection code
     * @property Show\Field|Collection params
     * @property Show\Field|Collection period
     * @property Show\Field|Collection rule
     * @property Show\Field|Collection sku
     * @property Show\Field|Collection status
     * @property Show\Field|Collection bak_table
     * @property Show\Field|Collection date
     * @property Show\Field|Collection table_name
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection uuid
     * @property Show\Field|Collection city
     * @property Show\Field|Collection district
     * @property Show\Field|Collection ip_end
     * @property Show\Field|Collection ip_start
     * @property Show\Field|Collection lat
     * @property Show\Field|Collection lng
     * @property Show\Field|Collection nation
     * @property Show\Field|Collection nation_code
     * @property Show\Field|Collection province
     * @property Show\Field|Collection timezone
     * @property Show\Field|Collection zip_code
     * @property Show\Field|Collection attachments
     * @property Show\Field|Collection content
     * @property Show\Field|Collection sub_user
     * @property Show\Field|Collection subject
     * @property Show\Field|Collection adcode
     * @property Show\Field|Collection detail_id
     * @property Show\Field|Collection ipv4
     * @property Show\Field|Collection nation_en
     * @property Show\Field|Collection sid
     * @property Show\Field|Collection user_agent
     * @property Show\Field|Collection bno
     * @property Show\Field|Collection del
     * @property Show\Field|Collection failure_cnt
     * @property Show\Field|Collection finish_cnt
     * @property Show\Field|Collection free_cnt
     * @property Show\Field|Collection mail_id
     * @property Show\Field|Collection paid_cnt
     * @property Show\Field|Collection processed_at
     * @property Show\Field|Collection real_cash
     * @property Show\Field|Collection reply
     * @property Show\Field|Collection score_code
     * @property Show\Field|Collection sender
     * @property Show\Field|Collection sender_name
     * @property Show\Field|Collection settle
     * @property Show\Field|Collection total_cash
     * @property Show\Field|Collection total_cnt
     * @property Show\Field|Collection mid
     * @property Show\Field|Collection is_free
     * @property Show\Field|Collection mail_status
     * @property Show\Field|Collection paid
     * @property Show\Field|Collection report_sent
     * @property Show\Field|Collection result_desc
     * @property Show\Field|Collection schedule_status
     * @property Show\Field|Collection send_status
     * @property Show\Field|Collection task_id
     * @property Show\Field|Collection verify_status
     * @property Show\Field|Collection mail_uid
     * @property Show\Field|Collection query_method
     * @property Show\Field|Collection api
     * @property Show\Field|Collection provider
     * @property Show\Field|Collection send_domain
     * @property Show\Field|Collection send_mail
     * @property Show\Field|Collection user
     * @property Show\Field|Collection weight
     * @property Show\Field|Collection reject
     * @property Show\Field|Collection report_spam
     * @property Show\Field|Collection unsubscribe
     * @property Show\Field|Collection token
     * @property Show\Field|Collection appid
     * @property Show\Field|Collection buyer_id
     * @property Show\Field|Collection buyer_logon_id
     * @property Show\Field|Collection buyer_pay_amount
     * @property Show\Field|Collection currency
     * @property Show\Field|Collection event_target
     * @property Show\Field|Collection gmt_payment
     * @property Show\Field|Collection invoice_amount
     * @property Show\Field|Collection notify_raw
     * @property Show\Field|Collection out_trade_no
     * @property Show\Field|Collection receipt_amount
     * @property Show\Field|Collection total_amount
     * @property Show\Field|Collection trade_no
     * @property Show\Field|Collection trade_status
     * @property Show\Field|Collection data
     * @property Show\Field|Collection order_id
     * @property Show\Field|Collection abilities
     * @property Show\Field|Collection last_used_at
     * @property Show\Field|Collection tokenable_id
     * @property Show\Field|Collection tokenable_type
     * @property Show\Field|Collection market_code
     * @property Show\Field|Collection end_time
     * @property Show\Field|Collection start_time
     * @property Show\Field|Collection type_user
     * @property Show\Field|Collection zero_clear
     * @property Show\Field|Collection price
     * @property Show\Field|Collection deposit
     * @property Show\Field|Collection init_amount
     * @property Show\Field|Collection init_type
     * @property Show\Field|Collection secret
     * @property Show\Field|Collection chatgpt
     * @property Show\Field|Collection frozen_amount
     * @property Show\Field|Collection init_date
     * @property Show\Field|Collection init_status
     * @property Show\Field|Collection account
     * @property Show\Field|Collection before_amount
     * @property Show\Field|Collection income
     * @property Show\Field|Collection mark
     * @property Show\Field|Collection order_no
     * @property Show\Field|Collection cash_max
     * @property Show\Field|Collection cash_min
     * @property Show\Field|Collection change_rate
     *
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection cnt(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection failure_at(string $label = null)
     * @method Show\Field|Collection code2(string $label = null)
     * @method Show\Field|Collection code3(string $label = null)
     * @method Show\Field|Collection country_code(string $label = null)
     * @method Show\Field|Collection amount(string $label = null)
     * @method Show\Field|Collection code(string $label = null)
     * @method Show\Field|Collection params(string $label = null)
     * @method Show\Field|Collection period(string $label = null)
     * @method Show\Field|Collection rule(string $label = null)
     * @method Show\Field|Collection sku(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection bak_table(string $label = null)
     * @method Show\Field|Collection date(string $label = null)
     * @method Show\Field|Collection table_name(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection uuid(string $label = null)
     * @method Show\Field|Collection city(string $label = null)
     * @method Show\Field|Collection district(string $label = null)
     * @method Show\Field|Collection ip_end(string $label = null)
     * @method Show\Field|Collection ip_start(string $label = null)
     * @method Show\Field|Collection lat(string $label = null)
     * @method Show\Field|Collection lng(string $label = null)
     * @method Show\Field|Collection nation(string $label = null)
     * @method Show\Field|Collection nation_code(string $label = null)
     * @method Show\Field|Collection province(string $label = null)
     * @method Show\Field|Collection timezone(string $label = null)
     * @method Show\Field|Collection zip_code(string $label = null)
     * @method Show\Field|Collection attachments(string $label = null)
     * @method Show\Field|Collection content(string $label = null)
     * @method Show\Field|Collection sub_user(string $label = null)
     * @method Show\Field|Collection subject(string $label = null)
     * @method Show\Field|Collection adcode(string $label = null)
     * @method Show\Field|Collection detail_id(string $label = null)
     * @method Show\Field|Collection ipv4(string $label = null)
     * @method Show\Field|Collection nation_en(string $label = null)
     * @method Show\Field|Collection sid(string $label = null)
     * @method Show\Field|Collection user_agent(string $label = null)
     * @method Show\Field|Collection bno(string $label = null)
     * @method Show\Field|Collection del(string $label = null)
     * @method Show\Field|Collection failure_cnt(string $label = null)
     * @method Show\Field|Collection finish_cnt(string $label = null)
     * @method Show\Field|Collection free_cnt(string $label = null)
     * @method Show\Field|Collection mail_id(string $label = null)
     * @method Show\Field|Collection paid_cnt(string $label = null)
     * @method Show\Field|Collection processed_at(string $label = null)
     * @method Show\Field|Collection real_cash(string $label = null)
     * @method Show\Field|Collection reply(string $label = null)
     * @method Show\Field|Collection score_code(string $label = null)
     * @method Show\Field|Collection sender(string $label = null)
     * @method Show\Field|Collection sender_name(string $label = null)
     * @method Show\Field|Collection settle(string $label = null)
     * @method Show\Field|Collection total_cash(string $label = null)
     * @method Show\Field|Collection total_cnt(string $label = null)
     * @method Show\Field|Collection mid(string $label = null)
     * @method Show\Field|Collection is_free(string $label = null)
     * @method Show\Field|Collection mail_status(string $label = null)
     * @method Show\Field|Collection paid(string $label = null)
     * @method Show\Field|Collection report_sent(string $label = null)
     * @method Show\Field|Collection result_desc(string $label = null)
     * @method Show\Field|Collection schedule_status(string $label = null)
     * @method Show\Field|Collection send_status(string $label = null)
     * @method Show\Field|Collection task_id(string $label = null)
     * @method Show\Field|Collection verify_status(string $label = null)
     * @method Show\Field|Collection mail_uid(string $label = null)
     * @method Show\Field|Collection query_method(string $label = null)
     * @method Show\Field|Collection api(string $label = null)
     * @method Show\Field|Collection provider(string $label = null)
     * @method Show\Field|Collection send_domain(string $label = null)
     * @method Show\Field|Collection send_mail(string $label = null)
     * @method Show\Field|Collection user(string $label = null)
     * @method Show\Field|Collection weight(string $label = null)
     * @method Show\Field|Collection reject(string $label = null)
     * @method Show\Field|Collection report_spam(string $label = null)
     * @method Show\Field|Collection unsubscribe(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection appid(string $label = null)
     * @method Show\Field|Collection buyer_id(string $label = null)
     * @method Show\Field|Collection buyer_logon_id(string $label = null)
     * @method Show\Field|Collection buyer_pay_amount(string $label = null)
     * @method Show\Field|Collection currency(string $label = null)
     * @method Show\Field|Collection event_target(string $label = null)
     * @method Show\Field|Collection gmt_payment(string $label = null)
     * @method Show\Field|Collection invoice_amount(string $label = null)
     * @method Show\Field|Collection notify_raw(string $label = null)
     * @method Show\Field|Collection out_trade_no(string $label = null)
     * @method Show\Field|Collection receipt_amount(string $label = null)
     * @method Show\Field|Collection total_amount(string $label = null)
     * @method Show\Field|Collection trade_no(string $label = null)
     * @method Show\Field|Collection trade_status(string $label = null)
     * @method Show\Field|Collection data(string $label = null)
     * @method Show\Field|Collection order_id(string $label = null)
     * @method Show\Field|Collection abilities(string $label = null)
     * @method Show\Field|Collection last_used_at(string $label = null)
     * @method Show\Field|Collection tokenable_id(string $label = null)
     * @method Show\Field|Collection tokenable_type(string $label = null)
     * @method Show\Field|Collection market_code(string $label = null)
     * @method Show\Field|Collection end_time(string $label = null)
     * @method Show\Field|Collection start_time(string $label = null)
     * @method Show\Field|Collection type_user(string $label = null)
     * @method Show\Field|Collection zero_clear(string $label = null)
     * @method Show\Field|Collection price(string $label = null)
     * @method Show\Field|Collection deposit(string $label = null)
     * @method Show\Field|Collection init_amount(string $label = null)
     * @method Show\Field|Collection init_type(string $label = null)
     * @method Show\Field|Collection secret(string $label = null)
     * @method Show\Field|Collection chatgpt(string $label = null)
     * @method Show\Field|Collection frozen_amount(string $label = null)
     * @method Show\Field|Collection init_date(string $label = null)
     * @method Show\Field|Collection init_status(string $label = null)
     * @method Show\Field|Collection account(string $label = null)
     * @method Show\Field|Collection before_amount(string $label = null)
     * @method Show\Field|Collection income(string $label = null)
     * @method Show\Field|Collection mark(string $label = null)
     * @method Show\Field|Collection order_no(string $label = null)
     * @method Show\Field|Collection cash_max(string $label = null)
     * @method Show\Field|Collection cash_min(string $label = null)
     * @method Show\Field|Collection change_rate(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
