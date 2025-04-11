FROM php:8.4-fpm

WORKDIR /var/www/html

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev

RUN docker-php-ext-install zip pdo pdo_pgsql

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

ARG UID=1000
ARG GID=1000

RUN groupadd -g ${GID} hostgroup \
    && useradd -u ${UID} -g hostgroup -m hostuser

USER hostuser

EXPOSE 9000
CMD ["php-fpm"]