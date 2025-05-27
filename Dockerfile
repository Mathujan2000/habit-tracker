FROM php:8.2-apache

# Enable mod_rewrite
RUN a2enmod rewrite

# Set ServerName to avoid Apache warnings
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip unzip curl git libzip-dev ca-certificates npm nodejs \
    && docker-php-ext-install zip pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy Laravel app code
COPY . .

# Copy custom Apache config (make sure apache.conf is next to Dockerfile)
COPY apache.conf /etc/apache2/sites-enabled/000-default.conf

# Set permissions for Laravel storage and cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Install PHP dependencies with Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Install npm dependencies and build assets
RUN npm install && npm run build

# Expose port 80
EXPOSE 80

# Run Apache in the foreground
CMD ["apache2-foreground"]
