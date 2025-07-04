FROM php:8.2-fpm

# 1. Install system dependencies
RUN apt-get update && \
    apt-get install -y \
        nginx \
        libpq-dev \
        postgresql-client \
        git \
        unzip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# 2. Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install \
        pdo \
        pdo_pgsql \
        gd \
        zip \
        opcache

# 3. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Copy files in optimal order
COPY composer.json composer.lock ./

# 5. First install dependencies without optimization
RUN composer install --no-dev --no-interaction --no-scripts --no-autoloader

# 6. Copy application files
COPY . .

# 7. Now complete the installation
RUN composer dump-autoload --optimize && \
    php artisan package:discover

# 8. Environment setup
COPY .env.example /var/www/html/.env
RUN php artisan key:generate && \
    php artisan storage:link

RUN rm -f /var/www/html/database/database.sqlite

# 9. Configure Nginx
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf
RUN sed -i 's/server_name _;/server_name localhost;/' /etc/nginx/conf.d/default.conf

# 10. Set permissions
RUN chown -R www-data:www-data \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage \
        /var/www/html/bootstrap/cache

# 11. Optimize
RUN echo "APP_DEBUG=true" >> /var/www/html/.env && \
    php artisan config:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# 12. Start script
COPY docker/start.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/start.sh

HEALTHCHECK --interval=30s --timeout=3s \
    CMD curl -f http://localhost/ || exit 1

CMD ["start.sh"]