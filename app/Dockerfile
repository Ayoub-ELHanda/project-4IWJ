# Dockerfile

# Utilisation de l'image PHP 8.1-fpm
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
# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier le contenu du répertoire d'application existant
#COPY ./my_project-symfony /var/www/html

# Exposer le port 9000 et démarrer le serveur php-fpm
EXPOSE 9000
CMD ["php-fpm"]
