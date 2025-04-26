#!/usr/bin/env bash
# Exit on error
set -o errexit

APP_DIR=$(pwd)
echo "Current application directory: $APP_DIR"
echo "Directory contents:"
ls -la

echo "Installing dependencies for MongoDB..."
apt-get update && apt-get install -y libssl-dev pkg-config

echo "Installing PHP extensions for MongoDB..."
pecl install mongodb

echo "Enabling MongoDB extension..."
echo "extension=mongodb.so" > /etc/php/8.2/cli/conf.d/20-mongodb.ini
echo "extension=mongodb.so" > /etc/php/8.2/fpm/conf.d/20-mongodb.ini

echo "Configure Apache..."
a2enmod rewrite

# Create a very simple Apache config that points directly to the public directory
cat > /etc/apache2/sites-available/000-default.conf << 'EOL'
<VirtualHost *:80>
    ServerName localhost
    DocumentRoot APP_DIR_PLACEHOLDER/public

    <Directory APP_DIR_PLACEHOLDER/public>
        AllowOverride All
        Require all granted
        Options -Indexes +FollowSymLinks
        DirectoryIndex index.php index.html
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOL

# Replace placeholder with actual app directory
sed -i "s|APP_DIR_PLACEHOLDER|$APP_DIR|g" /etc/apache2/sites-available/000-default.conf

# Add global ServerName to suppress warning
echo "ServerName localhost" >> /etc/apache2/apache2.conf

echo "Final Apache configuration:"
cat /etc/apache2/sites-available/000-default.conf

echo "Public directory contents:"
ls -la $APP_DIR/public || echo "Public directory not found!"

echo "Install project dependencies..."
composer install --no-interaction --no-dev --prefer-dist

echo "Building frontend assets..."
npm install
npm run build

echo "Checking public directory after build:"
ls -la $APP_DIR/public || echo "Public directory not found after build!"

echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Setting appropriate permissions..."
chmod -R 775 storage bootstrap/cache
chmod -R 755 public

echo "Debug: Checking Laravel public/index.php"
if [ -f "$APP_DIR/public/index.php" ]; then
    echo "index.php exists in public directory"
    cat $APP_DIR/public/index.php | head -n 5
else
    echo "ERROR: index.php not found in public directory!"
fi

echo "Build completed!" 