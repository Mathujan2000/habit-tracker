# Gebruik een officiële Apache + PHP base image
FROM php:8.2-apache

# Installeer systeemafhankelijkheden en tools
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Installeer PHP extensies
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Installeer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Zet Apache configuratie
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf && \
    a2enmod rewrite


# Werkdirectory instellen
WORKDIR /var/www/html

# Kopieer eerst alleen de composer bestanden voor efficiënte caching
COPY composer.json composer.lock ./

# Installeer PHP dependencies (zonder scripts om .env issues te voorkomen)
RUN composer install --no-scripts --no-autoloader --no-interaction --no-dev

# Kopieer alle bestanden (exclude onnodige bestanden via .dockerignore)
COPY . .

# Zet rechten goed
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage && \
    chmod -R 775 /var/www/html/bootstrap/cache

# Debug listing to check if .env.example exists
RUN ls -la /var/www/html

# Environment voorbereiden
RUN cp .env.example .env && \
    composer dump-autoload --optimize && \
    php artisan key:generate && \
    php artisan config:cache

# Installeer NPM dependencies en bouw assets
RUN npm install && npm run build

# Expose poort 80
EXPOSE 80

# Start Apache in foreground
CMD ["apache2-foreground"]
