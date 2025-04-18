#!/usr/bin/env bash
# Exit on error
set -o errexit

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node.js dependencies
npm ci
npm run build

# Set up Laravel
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
chmod -R 777 storage bootstrap/cache 