FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unixodbc-dev \
    && pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv

# Install PDO PostgreSQL extension
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql

RUN apt-get update \
    && apt-get install -y zlib1g-dev g++ git libicu-dev libzip-dev zip libpq-dev \
    && rm -rf /var/lib/apt/lists/*


RUN docker-php-ext-install intl opcache pdo pdo_pgsql zip \
    && pecl install apcu \
    && docker-php-ext-enable apcu

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# Définir le répertoire de travail
WORKDIR /var/www/html
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN curl -sS https://get.symfony.com/cli/installer | bash


RUN mv /root/.symfony*/bin/symfony /usr/local/bin/symfony
# Exposer le port 9000 et démarrer le serveur php-fpm
EXPOSE 9000
CMD ["php-fpm"]