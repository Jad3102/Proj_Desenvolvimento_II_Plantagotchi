FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get update && apt-get install -y default-mysql-client

COPY ./app /var/www/html
COPY ./db /var/www/html
