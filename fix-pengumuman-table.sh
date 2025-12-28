#!/bin/bash

echo "Memperbaiki error tabel pengumumen..."

cd /var/www/html/sd-jomblang2

# Perbaiki model Pengumuman
cat > app/Models/Pengumuman.php << 'EOL'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'isi'];
    
    // Tentukan nama tabel secara eksplisit
    protected $table = 'pengumumans';
}
EOL

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear

echo "Perbaikan model selesai!"
echo "Pastikan migrasi sudah dijalankan: php artisan migrate"
