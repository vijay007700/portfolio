FROM php:8.3-cli-alpine

RUN apk add --no-cache bash libxml2 libzip sqlite-libs \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS libxml2-dev libzip-dev sqlite-dev oniguruma-dev \
    && docker-php-ext-install dom mbstring pdo_sqlite simplexml xml xmlwriter zip \
    && CFLAGS="-I/usr/src/php" docker-php-ext-install xmlreader \
    && apk del .build-deps

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader \
    && mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache public/uploads \
    && touch database/database.sqlite \
    && chown -R www-data:www-data database storage bootstrap/cache public/uploads \
    && chmod +x docker-entrypoint.sh

USER www-data
EXPOSE 10000
ENTRYPOINT ["/var/www/html/docker-entrypoint.sh"]
