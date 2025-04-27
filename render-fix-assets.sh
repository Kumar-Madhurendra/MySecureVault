#!/usr/bin/env bash
# Script to fix asset loading issues on Render deployment

echo "==============================================="
echo "Fixing asset loading for Render deployment..."
echo "==============================================="

# 1. Ensure proper APP_URL and ASSET_URL are set
echo "Updating environment configuration..."
sed -i 's#APP_URL=.*#APP_URL=https://mysecurevault.onrender.com#' .env
if grep -q "ASSET_URL" .env; then
    sed -i 's#ASSET_URL=.*#ASSET_URL=${APP_URL}#' .env
else
    echo "ASSET_URL=\${APP_URL}" >> .env
fi

# 2. Switch to file-based session and cache to avoid database errors
sed -i 's/SESSION_DRIVER=.*/SESSION_DRIVER=file/' .env
sed -i 's/CACHE_STORE=.*/CACHE_STORE=file/' .env

# 3. Create/update necessary directories with correct permissions
echo "Setting up storage directories..."
DIRS=(
    "storage/framework"
    "storage/framework/sessions"
    "storage/framework/views"
    "storage/framework/cache"
    "storage/framework/cache/data"
    "storage/logs"
    "bootstrap/cache"
    "public/build"
)

for DIR in "${DIRS[@]}"; do
    if [ ! -d "$DIR" ]; then
        mkdir -p "$DIR"
        echo " - Created $DIR"
    fi
    chmod -R 775 "$DIR"
    echo " - Set permissions for $DIR"
done

# 4. Rebuild assets with correct URL configuration
echo "Building frontend assets..."
if [ -f "package.json" ]; then
    npm install
    npm run build
    echo " - Assets built successfully"
else
    echo " - No package.json found, skipping asset build"
fi

# 5. Clear Laravel caches
echo "Clearing Laravel caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

# 6. Cache for production
echo "Caching for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==============================================="
echo "Asset fix complete!"
echo "===============================================" 