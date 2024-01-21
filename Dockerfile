FROM php:8.0-apache

RUN a2enmod rewrite

# System dependencies
RUN apt-get update && apt-get upgrade -y \
    git \
    curl \
    zip \
    unzip

# PHP extensions
RUN docker-php-ext-install pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html