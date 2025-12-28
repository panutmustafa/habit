<?php

use App\Http\Controllers\GuruController; // Import GuruController
use App\Http\Controllers\AdminController; // Import AdminController
use App\Http\Controllers\SiswaController; // Import SiswaController
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // User Management
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('admin.users.index');
    Route::get('/users/create', [AdminController::class, 'usersCreate'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'usersStore'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'usersEdit'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminController::class, 'usersUpdate'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminController::class, 'usersDestroy'])->name('admin.users.destroy');

    // Class Management
    Route::get('/kelas', [AdminController::class, 'kelasIndex'])->name('admin.kelas.index');
    Route::get('/kelas/create', [AdminController::class, 'kelasCreate'])->name('admin.kelas.create');
    Route::post('/kelas', [AdminController::class, 'kelasStore'])->name('admin.kelas.store');
    Route::get('/kelas/{kela}/edit', [AdminController::class, 'kelasEdit'])->name('admin.kelas.edit');
    Route::put('/kelas/{kela}', [AdminController::class, 'kelasUpdate'])->name('admin.kelas.update');
    Route::delete('/kelas/{kela}', [AdminController::class, 'kelasDestroy'])->name('admin.kelas.destroy');

    // Habit Management
    Route::get('/habits', [AdminController::class, 'habitsIndex'])->name('admin.habits.index');
    Route::get('/habits/create', [AdminController::class, 'habitsCreate'])->name('admin.habits.create');
    Route::post('/habits', [AdminController::class, 'habitsStore'])->name('admin.habits.store');
    Route::get('/habits/{habit}/edit', [AdminController::class, 'habitsEdit'])->name('admin.habits.edit');
    Route::put('/habits/{habit}', [AdminController::class, 'habitsUpdate'])->name('admin.habits.update');
    Route::delete('/habits/{habit}', [AdminController::class, 'habitsDestroy'])->name('admin.habits.destroy');
});

// Teacher Routes
Route::middleware(['auth', \App\Http\Middleware\GuruMiddleware::class])->prefix('guru')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');
    Route::get('/students/{user}/habits', [GuruController::class, 'showStudentHabits'])->name('guru.students.habits');
    Route::get('/students/{user}/reflections', [GuruController::class, 'showStudentReflections'])->name('guru.students.reflections');
    Route::get('/reflections/{reflection}/review', [GuruController::class, 'reviewReflection'])->name('guru.reflections.review');
    Route::put('/reflections/{reflection}/feedback', [GuruController::class, 'storeReflectionFeedback'])->name('guru.reflections.feedback');
    Route::get('/report', [GuruController::class, 'generateReport'])->name('guru.report');
});

// Student Routes
Route::middleware(['auth', \App\Http\Middleware\SiswaMiddleware::class])->prefix('siswa')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'index'])->name('siswa.dashboard');
    Route::post('/habits/{habit}/mark', [SiswaController::class, 'markHabit'])->name('siswa.habits.mark');
    Route::get('/reflections/create', [SiswaController::class, 'createReflection'])->name('siswa.reflections.create');
    Route::post('/reflections', [SiswaController::class, 'storeReflection'])->name('siswa.reflections.store');
    Route::get('/reflections/{reflection}/edit', [SiswaController::class, 'editReflection'])->name('siswa.reflections.edit');
    Route::put('/reflections/{reflection}', [SiswaController::class, 'updateReflection'])->name('siswa.reflections.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
