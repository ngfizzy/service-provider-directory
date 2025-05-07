# Dockerfile (Laravel PHP-FPM for Production)
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    npm \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application source
COPY . /var/www
COPY ./docker/start-container.sh /var/www/docker/start-container.sh
RUN chmod +x /var/www/docker/start-container.sh

# Set permissions
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Build frontend assets
RUN npm install && npm run build

# Precompile Laravel caches
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Expose port used by php-fpm
EXPOSE 9000

CMD ["php-fpm"]
