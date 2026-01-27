#!/bin/bash
if [ "$DB_USER" = "" ]; then
    echo "请设置环境变量DB_USER"
    exit 1
fi
if [ "$DB_PWD" = "" ]; then
    echo "请设置环境变量DB_USER"
    exit 1
fi
if [ "$DB_HOST" = "" ]; then
    echo "请设置环境变量DB_HOST"
    exit 1
fi
if [ "$DB_NAME" = "" ]; then
    echo "请设置环境变量DB_NAME"
    exit 1
fi

days=$1
if [ "$1" = "" ]; then
    echo "Usage: $0 天数"
    exit 1
fi
date_now=$(date +%Y-%m-%d)
date_ago=$(date -d "$1 days ago" +%Y-%m-%d)" 00:00:00"
# 指定要导出的表和查询条件
host=$DB_HOST
db_name=$DB_NAME
t1="mail_schedule_details"
t2="mail_schedule_detail_histories"
column="id,email,user_id,sub_user,sid,mid,schedule_status,send_status,mail_status,verify_status,paid,settle,is_free,created_at,updated_at,task_id,result_desc,report_sent"
filter="where created_at < '${date_ago}' and send_status <> 4  and schedule_status not in (0,1)"
file="/home/ubuntu/bak/"$t1$date_now".sql"
tarFile="/home/ubuntu/bak/"$t1$date_now".tar.gz"
if [ ! -f "$tarFile" ]; then
    mysqldump -u${DB_USER} -p${DB_PWD} -h${host} ${db_name} ${t1} > $file
    tar -zcvf ${tarFile} ${file}
    unlink ${file}
fi
# 导出数据
mysql -u${DB_USER} -p${DB_PWD} -h${host} --database=${db_name} -e "insert into ${t2} (${column}) select ${column} from ${t1} $filter; delete from ${t1} ${filter};"
