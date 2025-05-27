FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl && \
    docker-php-ext-install zip

RUN a2enmod rewrite

COPY . /var/www/html/

WORKDIR /var/www/html/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
 && composer install

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
