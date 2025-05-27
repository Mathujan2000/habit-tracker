FROM php:8.2-apache

# Enable mod_rewrite
RUN a2enmod rewrite

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip unzip curl git libzip-dev ca-certificates \
    && docker-php-ext-install zip pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js and npm (Node 18)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Set working directory
WORKDIR /var/www/html

# Copy Laravel app code
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Install PHP dependencies with Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Install npm dependencies and build assets
RUN npm install && npm run build

# Expose port 80
EXPOSE 80
