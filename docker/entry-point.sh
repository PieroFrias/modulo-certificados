#!/usr/bin/env

chown -R www-data:www-data /var/www/app \
    && chmod -R 775 /var/www/app/storage

composer install

php artisan migrate --seed
php artisan key:generate
php-fpm
