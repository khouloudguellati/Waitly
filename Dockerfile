FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip curl zip \
    libzip-dev libicu-dev libpq-dev \
    nodejs npm

RUN docker-php-ext-install \
    pdo pdo_mysql pdo_pgsql pgsql zip bcmath intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN rm -f .env

RUN composer install --no-dev --optimize-autoloader

RUN php artisan storage:link || true

RUN npm ci
RUN npm run build

RUN chmod -R 775 storage bootstrap/cache

COPY docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

CMD ["/docker-entrypoint.sh"]