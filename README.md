# Ice Project

A Laravel-based media management application with Aliyun OSS integration, MongoDB database support, and Redis caching.

## Project Overview

This project is designed to handle media uploads, processing, and management with the following key features:

- File upload to Aliyun OSS
- Video processing via Aliyun Intelligent Media Service
- MongoDB database backend
- Redis caching and queue system
- JWT authentication
- Real-time updates via Pusher

## Technology Stack

- **Framework:** Laravel
- **Language:** PHP 8.2
- **Database:** MongoDB
- **Cache/Queue:** Redis
- **File Storage:** Aliyun OSS
- **Containerization:** Docker

## Prerequisites

### Local Development
- PHP 8.2+
- Composer
- MongoDB
- Redis
- Node.js (for frontend assets)

### Docker Deployment
- Docker
- Docker Compose

## Installation

## Docker Deployment

### 阿里云只能媒体服务订阅
1. 打开https://ice.console.aliyun.com/, 开通服务

2.配置存储
![alt text](image.png)

3.配置`.env`文件
```env
# Aliyun Configuration
ALIYUN_VIDEO_ACCESS_KEY_ID=your_access_key_id
ALIYUN_VIDEO_ACCESS_KEY_SECRET=your_access_key_secret
ALIYUN_VIDEO_BUCKET=your_bucket_name
ALIYUN_STS_ACCESS_KEY_ID=your_sts_key_id
ALIYUN_STS_ACCESS_KEY_SECRET=your_sts_secret
ALIYUN_ROLE_ARN=acs:ram::your_account_id:role/your_role_name
ALIYUN_ROLE_SESSION_NAME=your_session_name

# Database
DB_DATABASE=ice
DB_USERNAME=root
DB_PASSWORD=root
DB_CONNECTION=mongodb
DB_DSN=mongodb://root:root@127.0.0.1:27017

# Redis
REDIS_HOST=redis
REDIS_PORT=6379
REDIS_PASSWORD=your_redis_password

# jwt secret random string
JWT_SECRET=1qyZNoqwVsvnwwkzBLVbuouxxTF533Ekkl0wmzbrUBev9MO3fa7lNniP1V8F40mW

# PENGTOUR_API_URL
PENGTOUR_API_URL=https://addition-service.test.pintreel.com
```

### puhser配置

1. 打开https://pusher.com/，创建账号

2.获取key
![alt text](image-1.png)

3.配置`.env`

```env
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=
```

### deploy with script
```bash
chmod +x deploy.sh
./deploy.sh
```

### Config nginx reverse proxy
```
#PROXY-START/

location /
{
    proxy_pass http://127.0.0.1:8880;
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header REMOTE-HOST $remote_addr;
    proxy_set_header Upgrade $http_upgrade;
    proxy_set_header Connection $connection_upgrade;
    proxy_http_version 1.1;
    # proxy_hide_header Upgrade;

    add_header X-Cache $upstream_cache_status;

    #Set Nginx Cache


    set $static_file2Y3pF4r7 0;
    if ( $uri ~* "\.(gif|png|jpg|css|js|woff|woff2)$" )
    {
        set $static_file2Y3pF4r7 1;
        expires 1m;
        }
    if ( $static_file2Y3pF4r7 = 0 )
    {
    add_header Cache-Control no-cache;
    }
}

#PROXY-END/
```

