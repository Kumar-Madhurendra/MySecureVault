FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install MongoDB PHP extension
RUN apt-get update && apt-get install -y libssl-dev && \
    pecl install mongodb && \
    docker-php-ext-enable mongodb

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory
COPY . .

# Install dependencies with verbose output
RUN composer install --no-interaction --no-dev --optimize-autoloader --verbose

# Generate key
RUN php artisan key:generate

# Nginx configuration
COPY nginx.conf /etc/nginx/sites-available/default

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port
EXPOSE 8080

# Start PHP-FPM and Nginx
CMD sh -c "php-fpm -D && nginx -g 'daemon off;'" 