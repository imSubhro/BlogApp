# Use PHP with Apache for production serving
FROM php:8.2-apache

# 1. Install system dependencies
# libpq-dev for Postgres, npm/nodejs for build
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql zip bcmath

# 2. Install Node.js (Version 18.x or 20.x is recommended)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# 3. Apache Configuration
# Enable mod_rewrite for Laravel
RUN a2enmod rewrite

# Change Apache document root to /var/www/html/public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf
RUN sed -ri -e 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf
RUN echo "ServerName blogapp-qe03.onrender.com" >> /etc/apache2/apache2.conf

# 4. Set Working Directory
WORKDIR /var/www/html

# 5. Install Composer Dependencies
# Copy only composer files first to leverage Docker cache
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# 6. Install Frontend Dependencies
COPY package.json package-lock.json ./
RUN npm ci

# 7. Copy Application Code
COPY . .

# 8. Build Frontend Assets
RUN npm run build

# 9. Finish Composer Setup (Autoload & Scripts)
RUN composer dump-autoload --optimize

# 10. Permissions
# Give write access to www-data (server user)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 11. Entrypoint
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh
# Fix for Windows line endings (CRLF -> LF)
RUN sed -i 's/\r$//' /usr/local/bin/start.sh

# Default port for Apache is 80
EXPOSE 80

CMD ["/usr/local/bin/start.sh"]
