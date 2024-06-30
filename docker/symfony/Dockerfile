FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unixodbc-dev \
    zlib1g-dev \
    g++ \
    git \
    libicu-dev \
    libzip-dev \
    zip \
    && pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql intl opcache zip \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && rm -rf /var/lib/apt/lists/*

# Install wkhtmltopdf
RUN apt-get update && apt-get install -y \
    wkhtmltopdf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Install Symfony Web Profiler Pack
RUN composer require --dev symfony/profiler-pack

# Set working directory
WORKDIR /var/www/symfony_docker

# Expose port 9000 and start php-fpm
EXPOSE 9000
CMD ["php-fpm"]
