FROM php:8.3-fpm-alpine AS base

RUN apk add --no-cache \
    nginx supervisor nodejs npm \
    libpng-dev libzip-dev postgresql-dev \
    && docker-php-ext-install pdo_pgsql pgsql zip gd

WORKDIR /app

COPY composer.json composer.lock ./
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --no-scripts --no-autoloader

COPY . .
RUN composer dump-autoload --optimize

COPY package.json package-lock.json ./
RUN npm ci && npm run build

RUN php artisan config:cache && php artisan route:cache

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 10000

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]