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

# 3. Seed categories and tags (uses firstOrCreate, safe to re-run)
echo "Seeding categories and tags..."
php artisan db:seed --class=CategoryTagSeeder --force

# 4. Link storage if not exists (re-link to ensure correctness)
rm -rf public/storage
php artisan storage:link

# 5. Start Apache (in foreground)
echo "✅ Deployment complete! Starting Apache..."
exec apache2-foreground

