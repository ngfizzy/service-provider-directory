#!/bin/bash

set -e

# Wait for MySQL to be ready
until mysqladmin ping -h "$DB_HOST" --silent; do
  echo "Waiting for MySQL..."
  sleep 2
done

echo "🧩 Running production setup..."

composer install


# Rebuild Laravel cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations with seed
php artisan migrate --force --seed
composer install --no-dev --optimize-autoloader


# Set proper permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

echo "App is ready"

exec "$@"
