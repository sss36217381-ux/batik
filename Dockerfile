# Multi-stage Dockerfile for ERP Batik Madura (PHP 8.2 + Composer + PostgreSQL)
FROM php:8.2-fpm-alpine as base

# Install system dependencies & PostgreSQL dev libraries
RUN apk add --no-cache \
    bash \
    curl \
    git \
    libpng-dev \
    libzip-dev \
    libpq-dev \
    zip \
    unzip \
    icu-dev \
    oniguruma-dev

# Install PHP extensions required by Laravel & PostgreSQL
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    pdo_mysql \
    bcmath \
    gd \
    intl \
    opcache \
    zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files and install PHP dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy application source code
COPY . .

# Finish composer autoload
RUN composer dump-autoload --optimize

# Set file permissions for Laravel storage & bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
