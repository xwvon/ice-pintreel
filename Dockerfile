FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    composer \
    curl \
    git \
    libpng-dev \
    libjpeg-turbo-dev \
    libfreetype6-dev \
    zip \
    unzip \
    $PHPIZE_DEPS

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) \
    gd \
    pdo \
    pdo_mysql \
    bcmath \
    ctype \
    json \
    tokenizer

# Install MongoDB extension
RUN pecl install mongodb && \
    docker-php-ext-enable mongodb

# Install Redis extension
RUN pecl install redis && \
    docker-php-ext-enable redis

# Set working directory
WORKDIR /app

# Copy composer files
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Copy application files
COPY . .

# Create necessary directories and set permissions
RUN chmod -R 755 storage bootstrap/cache && \
    chown -R www-data:www-data /app

# Configure PHP-FPM
RUN sed -i 's/user = www-data/user = www-data/' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's/group = www-data/group = www-data/' /usr/local/etc/php-fpm.d/www.conf

# Copy nginx configuration
COPY nginx.conf /etc/nginx/nginx.conf
COPY nginx.htaccess /etc/nginx/conf.d/default.conf

# Expose port
EXPOSE 80

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=40s --retries=3 \
    CMD curl -f http://localhost/health || exit 1

# Start both PHP-FPM and Nginx
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
