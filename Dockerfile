FROM php:7.4-fpm-alpine

RUN apk update \
    && apk add --no-cache --virtual build-dependencies icu-dev g++ make autoconf \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && apk del build-dependencies \
    && rm -rf /tmp/*

WORKDIR /var/www/html
