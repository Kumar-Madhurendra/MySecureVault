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
    libssl-dev \
    pkg-config \
    libcurl4-openssl-dev \
    libsasl2-dev \
    wget

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# MongoDB: Install pre-built extension instead of compiling
RUN mkdir -p /usr/src/php/ext/mongodb
RUN wget https://pecl.php.net/get/mongodb-1.16.2.tgz -O mongodb.tgz
RUN tar -xf mongodb.tgz -C /usr/src/php/ext/mongodb --strip-components=1
RUN rm mongodb.tgz
RUN docker-php-ext-install -j$(nproc) mongodb

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create storage directory structure if not exists
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Install dependencies without MongoDB compilation
RUN composer install --no-dev --optimize-autoloader

# Run npm build for assets
RUN npm install && npm run build

# Apache config
RUN a2enmod rewrite
COPY ./.docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Expose port
EXPOSE 8080

# Start the server
CMD ["apache2-foreground"] 