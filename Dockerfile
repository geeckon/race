FROM php:8.1.1-fpm
RUN apt update -y && apt install -y openssl zip unzip git mariadb-client
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash
RUN apt install nodejs
