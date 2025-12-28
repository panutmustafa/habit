#!/bin/bash

echo "Memperbaiki middleware admin auth..."

cd /var/www/html/sd-jomblang2

# Pastikan file middleware ada
if [ ! -f "app/Http/Middleware/AdminAuth.php" ]; then
    cat > app/Http/Middleware/AdminAuth.php << 'EOL'
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        return $next($request);
    }
}
EOL
    echo "File middleware dibuat."
fi

# Update Kernel.php
if grep -q "'admin.auth'" "app/Http/Kernel.php"; then
    echo "Middleware sudah terdaftar di Kernel."
else
    # Backup kernel
    cp app/Http/Kernel.php app/Http/Kernel.php.backup
    
    # Tambahkan middleware ke kernel
    sed -i "/'verified' => \\Illuminate\\Auth\\Middleware\\EnsureEmailIsVerified::class,/a\\\n        // Middleware admin\n        'admin.auth' => \\App\\Http\\Middleware\\AdminAuth::class," app/Http/Kernel.php
    echo "Middleware ditambahkan ke Kernel."
fi

# Clear cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo "Perbaikan selesai. Silakan coba lagi."
