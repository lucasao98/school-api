FROM php:8.3.28-fpm-alpine3.21
RUN apk add --no-cache openssl bash mysql-client nodejs npm
RUN docker-php-ext-install pdo pdo_mysql bcmath

WORKDIR /var/www

RUN chown www-data:www-data /var/www/html/

RUN rm -rf /var/www/html

RUN ln -s public html


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 9000


ENTRYPOINT ["php-fpm"]
