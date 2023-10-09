FROM php:apache-bullseye

WORKDIR /var/www/html

COPY . .

EXPOSE 8080

RUN docker-php-ext-install mysqli