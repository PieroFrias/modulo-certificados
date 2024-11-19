FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libfreetype-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zlib1g-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo_mysql

COPY . /var/www/app
WORKDIR /var/www/app

COPY --from=composer:2.6.5 /usr/bin/composer /usr/local/bin/composer

COPY composer.json ./
COPY ./docker/entry-point.sh ./docker/entry-point.sh
RUN chmod +x ./docker/entry-point.sh
ENTRYPOINT ["./docker/entry-point.sh"]
