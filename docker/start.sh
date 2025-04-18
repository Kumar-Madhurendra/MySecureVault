#!/bin/bash

# Function to check MongoDB connection
check_mongodb() {
    php artisan tinker --execute="try { DB::connection('mongodb')->getMongoClient()->listDatabases(); echo 'MongoDB connection successful\n'; } catch (\Exception \$e) { echo 'MongoDB connection failed: ' . \$e->getMessage() . '\n'; exit(1); }"
}

# Wait for MongoDB to be ready
echo "Checking MongoDB connection..."
RETRIES=30
WAIT_SECONDS=10

for i in $(seq 1 $RETRIES); do
    if check_mongodb; then
        break
    fi
    echo "Attempt $i/$RETRIES: MongoDB not ready. Waiting $WAIT_SECONDS seconds..."
    sleep $WAIT_SECONDS
    if [ $i -eq $RETRIES ]; then
        echo "Could not connect to MongoDB after $RETRIES attempts. Exiting."
        exit 1
    fi
done

# Run database migrations
php artisan migrate --force

# Clear cache and optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start PHP-FPM
php-fpm -D

# Start Nginx
nginx -g "daemon off;" 