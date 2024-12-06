#!/bin/bash
chown -R www-data:www-data /var/www/app/storage /var/www/app/bootstrap/cache
chmod -R 775 /var/www/app/storage /var/www/app/bootstrap/cache

composer install
php artisan config:cache
php artisan migrate --seed
php artisan key:generate
php artisan cache:clear
php artisan config:clear
php artisan router:clear
php artisan view:clear
php artisan storage:link

php artisan serve --host=0.0.0.0 --port=8001
