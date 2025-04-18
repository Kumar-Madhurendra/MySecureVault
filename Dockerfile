FROM php:8.2-fpm as php-base

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install MongoDB extension with better caching
RUN pecl install mongodb-1.16.2 \
    && docker-php-ext-enable mongodb

FROM node:18 as node-builder
WORKDIR /app
COPY package*.json ./
RUN npm install --production=false
COPY . .
# Set NODE_ENV and run build
ENV NODE_ENV=production \
    VITE_APP_ENV=production
RUN npm run build

FROM php-base as final
# Install nginx
RUN apt-get install -y nginx

# Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy node build artifacts
COPY --from=node-builder /app/public/build /var/www/html/public/build

# Set working directory
WORKDIR /var/www/html

# Copy composer files first
COPY composer.json composer.lock ./

# Install composer dependencies
RUN composer install --no-scripts --no-autoloader --no-dev

# Copy the rest of the application code
COPY . .

# Generate optimized autoload files
RUN composer dump-autoload --optimize

# Copy nginx configuration
COPY docker/nginx/laravel.conf /etc/nginx/conf.d/default.conf

# Create storage directory and set permissions
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p storage/logs \
    && chown -R www-data:www-data storage \
    && chown -R www-data:www-data bootstrap/cache \
    && chmod -R 775 storage \
    && chmod -R 775 bootstrap/cache

# Generate Laravel storage link
RUN php artisan storage:link

# Add healthcheck
HEALTHCHECK --interval=30s --timeout=10s --start-period=30s --retries=3 \
    CMD curl -f http://localhost/health || exit 1

# Expose port 80
EXPOSE 80

# Copy and set permissions for start script
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Start services
CMD ["/usr/local/bin/start.sh"] 