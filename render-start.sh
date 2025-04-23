#!/usr/bin/env bash

echo "Running composer install..."
composer install --no-dev --working-dir=/var/www/html

echo "Generating app key..."
php artisan key:generate --force

echo "Caching configuration..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

echo "Starting PHP-FPM and Nginx..."
php-fpm -D && nginx -g 'daemon off;' 