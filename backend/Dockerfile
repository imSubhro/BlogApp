FROM php:8.2-cli

# System deps
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_pgsql

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# PHP deps
RUN composer install --no-dev --optimize-autoloader

# Frontend deps + build (THIS FIXES VITE ERROR)
RUN npm install
RUN npm run build

# Storage
RUN php artisan storage:link || true

# Start script
COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 10000

CMD ["/start.sh"]
