FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    curl \
    git \
    libzip-dev \
    ca-certificates \
    && docker-php-ext-install zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js and npm (via NodeSource)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Set working directory
WORKDIR /var/www/html

# Copy app code
COPY . .

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Install PHP dependencies using Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Install JS dependencies using npm
RUN npm install
