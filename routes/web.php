<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pengguna', [\App\Http\Controllers\Master\UserController::class, 'index'])->name('pengguna.index');
    Route::post('/pengguna', [\App\Http\Controllers\Master\UserController::class, 'store'])->name('pengguna.store');
    Route::get('/pengguna/getallpagination', [\App\Http\Controllers\Master\UserController::class, 'getAllPagination'])->name('pengguna.getallpagination');
    Route::post('/pengguna/bulk-delete', [\App\Http\Controllers\Master\UserController::class, 'destroyBulk'])->name('pengguna.destroy-bulk');
    Route::get('/pengguna/{id}', [\App\Http\Controllers\Master\UserController::class, 'show'])->name('pengguna.show');
    Route::post('/pengguna/update/{id}', [\App\Http\Controllers\Master\UserController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/delete/{id}', [\App\Http\Controllers\Master\UserController::class, 'destroy'])->name('pengguna.destroy');

    // Kategori
    Route::get('/kategori', [\App\Http\Controllers\Master\CategoryController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/getallpagination', [\App\Http\Controllers\Master\CategoryController::class, 'getAllPagination'])->name('kategori.getallpagination');
    Route::post('/kategori', [\App\Http\Controllers\Master\CategoryController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{kategori}', [\App\Http\Controllers\Master\CategoryController::class, 'show'])->name('kategori.show');
    Route::put('/kategori/{kategori}', [\App\Http\Controllers\Master\CategoryController::class, 'update'])->name('kategori.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
