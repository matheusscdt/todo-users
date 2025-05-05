FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html