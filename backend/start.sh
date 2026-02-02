#!/bin/sh

echo "Starting Laravel..."

php artisan key:generate --force || true
php artisan migrate --force || true
php artisan optimize:clear || true
php artisan config:cache || true

php artisan serve --host=0.0.0.0 --port=10000
