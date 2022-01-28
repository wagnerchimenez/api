FROM php:8-apache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get update && apt-get install apt-utils && apt-get install -y git libzip-dev unzip \
    && apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && a2enmod rewrite headers

COPY . /var/www/html

COPY ./config/php.ini /usr/local/etc/php

WORKDIR /var/www/html/app

RUN composer install
