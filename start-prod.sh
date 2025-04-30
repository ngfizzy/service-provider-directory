#!/bin/bash

set -e

echo "Installing PHP dependencies..."
composer install 

echo "Clearing and rebuilding Laravel caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "🚀 Rebuilding optimized caches..."
php artisan config:cache --env=production
php artisan route:cache --env=production
php artisan view:cache --env=production

echo "🗃️ Running database migrations..."
php artisan migrate --force --seed --env=production


echo "Installing production PHP dependencies..."
composer install --no-dev --optimize-autoloader

echo "Building frontend assets..."
npm install
npm run build

echo "Starting Laravel application in production mode..."
php artisan serve --env=production --host=127.0.0.1 --port=8000
