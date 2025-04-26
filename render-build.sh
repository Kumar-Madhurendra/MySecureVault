#!/usr/bin/env bash
# Exit on error
set -o errexit

echo "Debugging directory structure..."
echo "Current directory: $(pwd)"
ls -la
echo "Checking public directory..."
ls -la public || echo "Public directory not found!"

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
    ServerAdmin webmaster@localhost
    ServerName mysecurevault.onrender.com
    DocumentRoot /var/www/html/public
    
    <Directory /var/www/html/public>
        AllowOverride All
        Require all granted
        Options -Indexes +FollowSymLinks
        DirectoryIndex index.php index.html
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Add global ServerName to suppress warning
echo 'ServerName mysecurevault.onrender.com' >> /etc/apache2/apache2.conf

# Make sure the system knows where the app is
echo "Checking if /var/www/html exists..."
if [ ! -d "/var/www/html" ]; then
    echo "Creating /var/www/html directory..."
    mkdir -p /var/www/html
fi

echo "Current directory content:"
ls -la
echo "Copying all files to /var/www/html..."
cp -R . /var/www/html/
echo "Setting correct permissions for /var/www/html..."
chown -R www-data:www-data /var/www/html

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

echo "Checking final directory structure..."
echo "Root directory:"
ls -la /var/www/html/
echo "Public directory:"
ls -la /var/www/html/public/

echo "Build completed!" 