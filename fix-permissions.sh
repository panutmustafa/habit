#!/bin/bash

echo "Memperbaiki permission untuk SD Negeri Jomblang 2..."

# Navigasi ke direktori project
cd /var/www/html/sd-jomblang2

# Backup composer.json (jika needed)
cp composer.json composer.json.backup

# Set ownership yang tepat
sudo chown -R $USER:www-data .

# Set permission yang tepat
sudo find . -type f -exec chmod 664 {} \;
sudo find . -type d -exec chmod 775 {} \;
sudo chmod -R 777 storage/ bootstrap/cache/

# Jika vendor folder ada, beri permission
if [ -d "vendor" ]; then
    sudo chmod -R 775 vendor/
fi

# Hapus vendor folder untuk fresh install
if [ -d "vendor" ]; then
    echo "Menghapus vendor folder lama..."
    rm -rf vendor/
fi

# Install Composer dependencies
echo "Menginstall dependencies..."
composer install --no-dev --no-scripts

# Generate autoloader
echo "Generating autoloader..."
composer dump-autoload --optimize

echo "Selesai! Silakan coba php artisan migrate lagi."
