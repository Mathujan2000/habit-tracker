FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
# Set working directory
WORKDIR /var/www/html

# Copy app code
COPY . .

# Install PHP dependencies using Composer
RUN composer install

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
