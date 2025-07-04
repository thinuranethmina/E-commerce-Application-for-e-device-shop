FROM php:8.2-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
        libpq-dev \
        libzip-dev \
        zip unzip git curl nano \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_pgsql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN php artisan config:cache

CMD php artisan serve --host=0.0.0.0 --port=8000
