FROM php:7.4-fpm-alpine

RUN apk update \ 
    && apk add --update icu-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql

WORKDIR /var/www/html
