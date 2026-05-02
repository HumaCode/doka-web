<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Kegiatan\KegiatanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pending-activation', [\App\Http\Controllers\Auth\AccountActivationController::class, 'index'])->middleware('auth')->name('pending.activation');
Route::get('/admin/quick-login/{user}', [\App\Http\Controllers\Auth\AccountActivationController::class, 'quickLogin'])->name('admin.quick-login');
Route::post('/pending-activation/submit', [\App\Http\Controllers\Auth\AccountActivationController::class, 'submit'])->middleware('auth')->name('pending.activation.submit');

Route::middleware(['auth', 'verified', 'active'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Pengguna
    Route::get('/pengguna', [\App\Http\Controllers\Master\UserController::class, 'index'])->name('pengguna.index');
    Route::post('/pengguna', [\App\Http\Controllers\Master\UserController::class, 'store'])->name('pengguna.store');
    Route::get('/pengguna/getallpagination', [\App\Http\Controllers\Master\UserController::class, 'getAllPagination'])->name('pengguna.getallpagination');
    Route::post('/pengguna/bulk-delete', [\App\Http\Controllers\Master\UserController::class, 'destroyBulk'])->name('pengguna.destroy-bulk');
    Route::get('/pengguna/{id}', [\App\Http\Controllers\Master\UserController::class, 'show'])->name('pengguna.show');
    Route::post('/pengguna/update/{id}', [\App\Http\Controllers\Master\UserController::class, 'update'])->name('pengguna.update');
    Route::patch('/pengguna/{id}/toggle', [\App\Http\Controllers\Master\UserController::class, 'toggleStatus'])->name('pengguna.toggle');
    Route::delete('/pengguna/delete/{id}', [\App\Http\Controllers\Master\UserController::class, 'destroy'])->name('pengguna.destroy');

    // Kategori
    Route::get('/kategori', [\App\Http\Controllers\Master\CategoryController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/getallpagination', [\App\Http\Controllers\Master\CategoryController::class, 'getAllPagination'])->name('kategori.getallpagination');
    Route::post('/kategori', [\App\Http\Controllers\Master\CategoryController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{kategori}', [\App\Http\Controllers\Master\CategoryController::class, 'show'])->name('kategori.show');
    Route::put('/kategori/{kategori}', [\App\Http\Controllers\Master\CategoryController::class, 'update'])->name('kategori.update');
    Route::patch('/kategori/{kategori}/toggle', [\App\Http\Controllers\Master\CategoryController::class, 'toggleStatus'])->name('kategori.toggle');
    Route::delete('/kategori/{kategori}', [\App\Http\Controllers\Master\CategoryController::class, 'destroy'])->name('kategori.destroy');

    // Unit Kerja
    Route::get('/unit-kerja', [\App\Http\Controllers\Master\UnitKerjaController::class, 'index'])->name('unit-kerja.index');
    Route::get('/unit-kerja/getallpagination', [\App\Http\Controllers\Master\UnitKerjaController::class, 'getAllPagination'])->name('unit-kerja.getallpagination');
    Route::post('/unit-kerja', [\App\Http\Controllers\Master\UnitKerjaController::class, 'store'])->name('unit-kerja.store');
    Route::get('/unit-kerja/{id}', [\App\Http\Controllers\Master\UnitKerjaController::class, 'show'])->name('unit-kerja.show');
    Route::put('/unit-kerja/{id}', [\App\Http\Controllers\Master\UnitKerjaController::class, 'update'])->name('unit-kerja.update');
    Route::patch('/unit-kerja/{id}/toggle', [\App\Http\Controllers\Master\UnitKerjaController::class, 'toggleStatus'])->name('unit-kerja.toggle');
    Route::patch('/unit-kerja/bulk-toggle', [\App\Http\Controllers\Master\UnitKerjaController::class, 'bulkToggleStatus'])->name('unit-kerja.bulk-toggle');
    Route::delete('/unit-kerja/bulk-delete', [\App\Http\Controllers\Master\UnitKerjaController::class, 'bulkDelete'])->name('unit-kerja.bulk-delete');
    Route::delete('/unit-kerja/{id}', [\App\Http\Controllers\Master\UnitKerjaController::class, 'destroy'])->name('unit-kerja.destroy');

    // Kegiatan
    Route::prefix('kegiatan')->name('kegiatan.')->group(function() {
        Route::get('/', [KegiatanController::class, 'index'])->name('index');
        Route::get('/data', [KegiatanController::class, 'getAllPagination'])->name('getData');
        Route::get('/show/{id}', [KegiatanController::class, 'show'])->name('show');
        Route::get('/tambah', [KegiatanController::class, 'create'])->name('create');
        Route::post('/store', [KegiatanController::class, 'store'])->name('store');
        Route::get('/download/{uuid}', [KegiatanController::class, 'download'])->name('download');
        Route::get('/{id}/edit', [KegiatanController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [KegiatanController::class, 'update'])->name('update');
        Route::post('/bulk-delete', [KegiatanController::class, 'bulkDelete'])->name('bulkDelete');
        Route::delete('/{id}', [KegiatanController::class, 'destroy'])->name('destroy');
    });
});

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
