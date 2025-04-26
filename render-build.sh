#!/usr/bin/env bash
# Exit on error
set -o errexit

echo "Installing dependencies for MongoDB..."
apt-get update && apt-get install -y libssl-dev pkg-config

echo "Installing PHP extensions for MongoDB..."
pecl install mongodb

echo "Enabling MongoDB extension..."
echo "extension=mongodb.so" > /etc/php/8.2/cli/conf.d/20-mongodb.ini
echo "extension=mongodb.so" > /etc/php/8.2/fpm/conf.d/20-mongodb.ini

echo "Install project dependencies..."
composer install --no-interaction --no-dev --prefer-dist

echo "Building frontend assets..."
npm install
npm run build

echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Setting appropriate permissions..."
chmod -R 775 storage bootstrap/cache

echo "Build completed!" 