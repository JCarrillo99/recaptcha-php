FROM php:8.2-fpm-alpine

RUN apk add --no-cache bash \
    && docker-php-ext-install opcache

WORKDIR /var/www/html

COPY public /var/www/html/public
COPY src /var/www/html/src
COPY composer.json composer.lock /var/www/html/
COPY php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-interaction --prefer-dist

CMD ["php-fpm", "-F"]
