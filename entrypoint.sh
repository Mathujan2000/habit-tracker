#!/bin/sh

set -e

# Wacht tot de database beschikbaar is
echo "⏳ Wachten op database..."
until nc -z -v -w30 db 3306
do
  echo "⏳ Wachten op MySQL op db:3306..."
  sleep 5
done

echo "✅ Database bereikbaar. Start Laravel setup..."

# Laravel optimalisaties
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

echo "🚀 Laravel klaar. Start php-fpm..."
exec php-fpm
