FROM php:8.2-cli

# System dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Working directory
WORKDIR /var/www/html

# Copy project
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Create storage link (safe)
RUN php artisan storage:link || true

# Copy start script
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Expose Render port
EXPOSE 10000

# Start Laravel properly
CMD ["/start.sh"]
