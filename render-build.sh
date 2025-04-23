#!/usr/bin/env bash
# Exit on error
set -o errexit

echo "Installing dependencies..."
npm ci

echo "Building frontend assets with Vite..."
npm run build

echo "Install PHP dependencies..."
composer install --no-dev --optimize-autoloader

# Set up Laravel
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
chmod -R 777 storage bootstrap/cache 