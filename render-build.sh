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

echo "Configure Apache..."
a2enmod rewrite
echo '<VirtualHost *:80>
    ServerName localhost
    DocumentRoot /var/www/html/public
    
    <Directory /var/www/html/public>
        AllowOverride All
        Require all granted
        Options -Indexes +FollowSymLinks
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

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
chmod -R 755 public
chown -R www-data:www-data .

echo "Build completed!" 