# Choose our base image
FROM serversideup/php:8.3-frankenphp

# Switch to root so we can do root things
USER root

# Install the intl and bcmath extensions with root permissions
RUN install-php-extensions mongodb-1.20.1 igbinary

# Drop back to our unprivileged user
USER www-data

# Copy application files with correct ownership
COPY --chown=www-data:www-data . /var/www/html

# Install the dependencies
RUN composer install --ignore-platform-reqs --no-dev -a