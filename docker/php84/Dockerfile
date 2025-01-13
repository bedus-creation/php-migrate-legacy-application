FROM php:8.4-fpm

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN sed -i 's/9000/9001/g' /usr/local/etc/php-fpm.d/www.conf
RUN sed -i 's/9000/9001/g' /usr/local/etc/php-fpm.d/zz-docker.conf

EXPOSE 9001
CMD ["php-fpm"]
