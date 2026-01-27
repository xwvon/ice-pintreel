# Ice Pintreel Project

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

### Local Setup

1. Clone the repository:
```bash
git clone <repository-url>
cd ice.pintreel.com
```

2. Install dependencies:
```bash
composer install
npm install
```

3. Configure environment variables:
```bash
cp .env.example .env
php artisan key:generate
```

4. Update `.env` with your credentials:
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
DB_DSN=mongodb://root:password@127.0.0.1:27017

# Redis
REDIS_PASSWORD=your_redis_password
```

5. Generate necessary keys and tables:
```bash
php artisan migrate
php artisan queue:work
```

## Docker Deployment

### Quick Start with Docker Compose

1. Ensure `.env` is configured with Docker-compatible values:
```env
# Use Docker service names, not localhost
REDIS_HOST=redis
REDIS_PORT=6379
DB_DSN=mongodb://root:password@mongodb:27017
```

2. Build and start containers:
```bash
docker-compose up -d
```

3. Run migrations:
```bash
docker-compose exec app php artisan migrate
```

4. Access the application:
```
http://localhost
```

### Docker Build

Build the Docker image manually:
```bash
docker build -t ice-pintreel:latest .
```

Run the container:
```bash
docker run -d \
  --name ice-pintreel \
  -p 80:80 \
  -e DB_DSN=mongodb://user:password@mongodb:27017/ice \
  -e REDIS_HOST=redis \
  -e REDIS_PASSWORD=your_password \
  --link mongodb:mongodb \
  --link redis:redis \
  ice-pintreel:latest
```

## Environment Variables

Essential environment variables required for production:

| Variable | Description | Example |
|----------|-------------|---------|
| `APP_ENV` | Application environment | `production` |
| `APP_DEBUG` | Debug mode | `false` |
| `APP_KEY` | Laravel encryption key | Base64 encoded key |
| `DB_DSN` | MongoDB connection string | `mongodb://user:pass@host:27017/db` |
| `REDIS_HOST` | Redis host | `redis` (Docker) or `127.0.0.1` |
| `REDIS_PASSWORD` | Redis password | Your secure password |
| `ALIYUN_VIDEO_ACCESS_KEY_ID` | Aliyun access key | Your access key |
| `ALIYUN_VIDEO_ACCESS_KEY_SECRET` | Aliyun secret key | Your secret key |
| `ALIYUN_VIDEO_BUCKET` | Aliyun OSS bucket | `ai-video-translate` |
| `ALIYUN_STS_ACCESS_KEY_ID` | STS access key | Your STS key |
| `ALIYUN_STS_ACCESS_KEY_SECRET` | STS secret key | Your STS secret |
| `ALIYUN_ROLE_ARN` | IAM role ARN | `acs:ram::account:role/role-name` |
| `ALIYUN_ROLE_SESSION_NAME` | Session name | `session-name` |

## Project Structure

```
.
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Jobs/
│   ├── Models/
│   └── Libraries/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
├── storage/
├── tests/
├── Dockerfile
├── docker-compose.yml
├── composer.json
└── .env
```

## Key API Endpoints

### File Upload
- **POST** `/api/upload/simple` - Upload file to Aliyun OSS
- **GET** `/api/upload` - List user's media files
- **POST** `/api/upload/video` - Upload video files
- **POST** `/api/upload/credentials` - Get STS credentials

### Request/Response Examples

**Simple Upload:**
```bash
curl -X POST http://localhost/api/upload/simple \
  -F "file=@video.mp4" \
  -H "Authorization: Bearer TOKEN"
```

**Video Upload:**
```bash
curl -X POST http://localhost/api/upload/video \
  -F "video=@video1.mp4" \
  -F "video=@video2.mp4" \
  -H "Authorization: Bearer TOKEN"
```

## Database

### MongoDB Collections
The application uses MongoDB for storing:
- Media information and metadata
- User file references
- Media processing status

Run migrations:
```bash
php artisan migrate
```

## Queue Jobs

The application uses Redis queue for async processing:

- `RegisterMediaInfo` - Register and process uploaded media
- `SyncMediaProducingJob` - Sync media production status
- `SyncBatchMediaProducingJob` - Batch media synchronization
- `SyncMediaDetail` - Sync detailed media information
- `SyncMediaList` - Sync media list updates

Start queue worker:
```bash
php artisan queue:work
```

In Docker:
```bash
docker-compose exec app php artisan queue:work
```

## Development

### Running Tests
```bash
php artisan test
```

### Code Formatting
```bash
composer run-script format
```

### Building Frontend Assets
```bash
npm run dev      # Development
npm run prod     # Production
```

## Troubleshooting

### MongoDB Connection Issues
- Ensure MongoDB is running and accessible
- Check username/password in `DB_DSN`
- Verify network connectivity between app and MongoDB containers

### Redis Connection Issues
- Verify Redis is running
- Check `REDIS_PASSWORD` is correctly set
- Ensure Redis port (6379) is accessible

### File Upload Failures
- Verify Aliyun OSS credentials are correct
- Check bucket name matches `ALIYUN_VIDEO_BUCKET`
- Ensure file size is within limits (10MB for simple upload, 200MB for video)

### Queue Jobs Not Processing
- Check queue worker is running: `php artisan queue:work`
- Verify Redis connection
- Check logs in `storage/logs/`

## Logging

Log files are stored in `storage/logs/` directory. For Docker deployments, mount this volume for persistent logs:

```bash
docker run -v logs:/app/storage/logs ice-pintreel:latest
```

## Security Considerations

1. **Credentials Management**
   - Never commit `.env` files with real credentials
   - Use environment-specific `.env` files
   - Rotate Aliyun credentials regularly

2. **API Security**
   - All endpoints require JWT authentication
   - Enable CORS for trusted domains
   - Validate all file uploads

3. **Database Security**
   - Use strong MongoDB passwords
   - Enable authentication in production
   - Use network policies to restrict access

4. **Docker Security**
   - Run containers with non-root user
   - Use minimal base images
   - Regularly update dependencies

## Deployment

### Production Checklist

- [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Update all Aliyun credentials
- [ ] Configure MongoDB with authentication
- [ ] Set strong Redis password
- [ ] Enable HTTPS/TLS
- [ ] Configure CDN for static assets
- [ ] Set up monitoring and logging
- [ ] Configure backup strategy
- [ ] Run database migrations
- [ ] Clear all caches

### Cloud Deployment Examples

#### Azure Container Apps
```bash
az containerapp up \
  --resource-group mygroup \
  --name ice-pintreel \
  --source .
```

#### AWS ECS
```bash
aws ecs create-service \
  --cluster default \
  --service-name ice-pintreel \
  --task-definition ice-pintreel:1
```

#### Docker Swarm
```bash
docker stack deploy -c docker-compose.yml ice
```

## Support & Contribution

For issues and contributions, please refer to the project repository.

## License

This project is proprietary and confidential.
