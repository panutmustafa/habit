#!/bin/bash

echo "Memperbaiki semua masalah admin..."

cd /var/www/html/sd-jomblang2

# 1. Buat middleware jika belum ada
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
    echo "✓ Middleware AdminAuth dibuat"
fi

# 2. Perbaiki Kernel
if ! grep -q "'admin.auth'" "app/Http/Kernel.php"; then
    # Backup kernel
    cp app/Http/Kernel.php app/Http/Kernel.php.backup
    
    # Tambahkan middleware ke kernel
    sed -i "/'verified' =>/a\        'admin.auth' => \\\\App\\\\Http\\\\Middleware\\\\AdminAuth::class," app/Http/Kernel.php
    echo "✓ Middleware ditambahkan ke Kernel"
fi

# 3. Perbaiki routes
cat > routes/web.php << 'EOL'
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\KontakController;

// Rute Publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::post('/saran', [HomeController::class, 'saran'])->name('saran');

// Rute Admin - Auth
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'loginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
    
    // Gunakan middleware yang sudah terdaftar
    Route::middleware(['admin.auth'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        
        // Manajemen Berita
        Route::resource('berita', BeritaController::class)->except(['show']);
        
        // Manajemen Pengumuman
        Route::resource('pengumuman', PengumumanController::class)->except(['show']);
        
        // Manajemen Gallery
        Route::resource('gallery', GalleryController::class)->except(['show', 'edit', 'update']);
        
        // Manajemen Kontak
        Route::get('/kontak', [KontakController::class, 'index'])->name('admin.kontak.index');
        Route::post('/kontak', [KontakController::class, 'update'])->name('admin.kontak.update');
    });
});
EOL
echo "✓ Routes diperbaiki"

# 4. Clear cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo "✅ Semua perbaikan selesai! Silakan coba akses /admin/login lagi."
