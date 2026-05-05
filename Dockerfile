# Build PHP application with Composer and node assets
FROM php:8.2-fpm AS base

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libwebp-dev \
    libxml2-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install pdo_mysql zip bcmath gd pcntl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Install Composer dependencies in a separate stage
FROM composer:2 AS composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Build front-end assets in a separate stage
FROM node:20-alpine AS node-build
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run build

# Final runtime image
FROM base

RUN apt-get update && apt-get install -y nginx && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
COPY --from=composer /app/vendor ./vendor
COPY --from=node-build /app/public/build ./public/build
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY . .

RUN if [ ! -f .env ]; then cp .env.example .env; fi \
    && php artisan key:generate --force \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && mkdir -p /run/nginx

EXPOSE 80
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'" ]
