#!/bin/bash

# Deployment fix script for Laravel 500 errors
echo "=====================================
Laravel Deployment Fix Script
====================================="

# Update session and cache drivers to file-based
echo "
Updating .env file..."
if [ -f ".env" ]; then
    # Try to update session driver
    if grep -q "SESSION_DRIVER=" .env; then
        sed -i "s/SESSION_DRIVER=.*/SESSION_DRIVER=file/" .env
        echo " - Updated SESSION_DRIVER to file"
    else
        echo "SESSION_DRIVER=file" >> .env
        echo " - Added SESSION_DRIVER=file"
    fi
    
    # Try to update cache store
    if grep -q "CACHE_STORE=" .env; then
        sed -i "s/CACHE_STORE=.*/CACHE_STORE=file/" .env
        echo " - Updated CACHE_STORE to file"
    else
        echo "CACHE_STORE=file" >> .env
        echo " - Added CACHE_STORE=file"
    fi
else
    echo " - ERROR: .env file not found!"
fi

# Create and set permissions for required directories
echo "
Creating required directories and setting permissions..."
DIRS=(
    "storage/framework"
    "storage/framework/sessions"
    "storage/framework/views"
    "storage/framework/cache"
    "storage/logs"
    "bootstrap/cache"
)

for DIR in "${DIRS[@]}"; do
    if [ ! -d "$DIR" ]; then
        mkdir -p "$DIR"
        echo " - Created $DIR"
    fi
    chmod -R 775 "$DIR"
    echo " - Set permissions for $DIR"
done

# Clear Laravel caches
echo "
Clearing Laravel caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

# Restart web server (if needed)
echo "
NOTE: You may need to restart your web server (Apache/Nginx) to apply these changes."

echo "
Deployment fix completed!
=====================================" 