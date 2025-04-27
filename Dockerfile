FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    npm \
    nodejs \
    autoconf \
    build-essential \
    libssl-dev \
    pkg-config

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install MongoDB PHP extension
RUN pecl install mongodb && \
    docker-php-ext-enable mongodb

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create storage directory structure if not exists
RUN mkdir -p storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/logs

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Install dependencies (with MongoDB extension already installed)
RUN composer install --no-scripts --no-dev

# Run npm build for assets
RUN npm install && npm run build

# Apache config
RUN a2enmod rewrite
COPY ./.docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Expose port
EXPOSE 8080

# Generate autoloader with optimizations
RUN composer dump-autoload --optimize

# Start Apache
CMD ["apache2-foreground"] 