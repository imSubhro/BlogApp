#!/bin/sh
set -e

echo "🚀 Starting deployment script..."

# 1. Cache configuration for performance
echo "Caching config..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 2. Run database migrations
echo "Running migrations..."
php artisan migrate --force

# 3. Link storage if not exists (optional in some docker setups but good practice)
php artisan storage:link || true

# 4. Start Apache (in foreground)
echo "Starting Apache..."
exec apache2-foreground
