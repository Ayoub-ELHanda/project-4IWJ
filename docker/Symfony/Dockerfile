FROM php:8.1-fpm


RUN apt-get update \
    && apt-get install -y zlib1g-dev g++ git libicu-dev libzip-dev zip libpq-dev \
    && rm -rf /var/lib/apt/lists/*


RUN docker-php-ext-install intl opcache pdo pdo_pgsql zip \
    && pecl install apcu \
    && docker-php-ext-enable apcu


WORKDIR /var/www/symfony_docker
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN curl -sS https://get.symfony.com/cli/installer | bash


RUN mv /root/.symfony*/bin/symfony /usr/local/bin/symfony
