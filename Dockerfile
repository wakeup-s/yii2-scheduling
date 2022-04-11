FROM composer:2 as composer

FROM php:7.4-cli-alpine as php

RUN apk add \
        --no-cache \
        oniguruma-dev \
        git \
        unzip

RUN docker-php-ext-install mbstring

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json .

RUN composer install --prefer-dist --no-interaction --no-ansi

COPY . .
