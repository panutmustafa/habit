#!/bin/bash

echo "Memperbaiki MissingAppKeyException..."

cd /var/www/html/sd-jomblang2

# Backup .env jika belum ada
if [ ! -f ".env.backup" ]; then
    cp .env .env.backup
fi

# Generate APP_KEY
php artisan key:generate

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear

echo "APP_KEY berhasil di-generate!"
echo "Silakan jalankan: php artisan serve"
