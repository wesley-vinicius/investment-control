FROM php:8.0-fpm

RUN apt-get update \ 
    &&  apt-get install -y libmcrypt-dev  \
    nano 

RUN apt-get install -y libzip-dev \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo_mysql \
    && pecl install xdebug-3.0.0 \
    && docker-php-ext-enable xdebug 
    
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV XDEBUG_MODE=coverage

WORKDIR /application

RUN chmod -R 777 /application

RUN chown -R 1000:1000 /application

EXPOSE 89
