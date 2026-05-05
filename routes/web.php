<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Laporan\LaporanController;
use App\Http\Controllers\Laporan\ExportController;
use App\Http\Controllers\Kegiatan\KegiatanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\DashboardController::class, 'frontend'])->name('home');

Route::get('/pending-activation', [\App\Http\Controllers\Auth\AccountActivationController::class, 'index'])->middleware('auth')->name('pending.activation');
Route::get('/admin/quick-login/{user}', [\App\Http\Controllers\Auth\AccountActivationController::class, 'quickLogin'])->name('admin.quick-login');
Route::post('/pending-activation/submit', [\App\Http\Controllers\Auth\AccountActivationController::class, 'submit'])->middleware('auth')->name('pending.activation.submit');

Route::middleware(['auth', 'verified', 'active'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/search', [DashboardController::class, 'search'])->name('search.global');
    Route::get('/api/search', [DashboardController::class, 'apiSearch'])->name('search.api');
    
    // MASTER DATA
    Route::middleware('can:user.view')->group(function () {
        Route::get('/pengguna', [\App\Http\Controllers\Master\UserController::class, 'index'])->name('pengguna.index');
        Route::get('/pengguna/getallpagination', [\App\Http\Controllers\Master\UserController::class, 'getAllPagination'])->name('pengguna.getallpagination');
        Route::post('/pengguna', [\App\Http\Controllers\Master\UserController::class, 'store'])->name('pengguna.store');
        Route::get('/pengguna/{id}', [\App\Http\Controllers\Master\UserController::class, 'show'])->name('pengguna.show');
        Route::post('/pengguna/update/{id}', [\App\Http\Controllers\Master\UserController::class, 'update'])->name('pengguna.update');
        Route::patch('/pengguna/{id}/toggle', [\App\Http\Controllers\Master\UserController::class, 'toggleStatus'])->name('pengguna.toggle');
        Route::post('/pengguna/bulk-delete', [\App\Http\Controllers\Master\UserController::class, 'destroyBulk'])->name('pengguna.destroy-bulk');
        Route::delete('/pengguna/delete/{id}', [\App\Http\Controllers\Master\UserController::class, 'destroy'])->name('pengguna.destroy');
    });

    Route::middleware('can:kategori.manage')->group(function () {
        Route::get('/kategori', [\App\Http\Controllers\Master\CategoryController::class, 'index'])->name('kategori.index');
        Route::get('/kategori/getallpagination', [\App\Http\Controllers\Master\CategoryController::class, 'getAllPagination'])->name('kategori.getallpagination');
        Route::post('/kategori', [\App\Http\Controllers\Master\CategoryController::class, 'store'])->name('kategori.store');
        Route::get('/kategori/{kategori}', [\App\Http\Controllers\Master\CategoryController::class, 'show'])->name('kategori.show');
        Route::put('/kategori/{kategori}', [\App\Http\Controllers\Master\CategoryController::class, 'update'])->name('kategori.update');
        Route::patch('/kategori/{kategori}/toggle', [\App\Http\Controllers\Master\CategoryController::class, 'toggleStatus'])->name('kategori.toggle');
        Route::delete('/kategori/{kategori}', [\App\Http\Controllers\Master\CategoryController::class, 'destroy'])->name('kategori.destroy');
    });

    Route::middleware('can:unitkerja.manage')->group(function () {
        Route::get('/unit-kerja', [\App\Http\Controllers\Master\UnitKerjaController::class, 'index'])->name('unit-kerja.index');
        Route::get('/unit-kerja/getallpagination', [\App\Http\Controllers\Master\UnitKerjaController::class, 'getAllPagination'])->name('unit-kerja.getallpagination');
        Route::post('/unit-kerja', [\App\Http\Controllers\Master\UnitKerjaController::class, 'store'])->name('unit-kerja.store');
        Route::get('/unit-kerja/{id}', [\App\Http\Controllers\Master\UnitKerjaController::class, 'show'])->name('unit-kerja.show');
        Route::put('/unit-kerja/{id}', [\App\Http\Controllers\Master\UnitKerjaController::class, 'update'])->name('unit-kerja.update');
        Route::patch('/unit-kerja/{id}/toggle', [\App\Http\Controllers\Master\UnitKerjaController::class, 'toggleStatus'])->name('unit-kerja.toggle');
        Route::patch('/unit-kerja/bulk-toggle', [\App\Http\Controllers\Master\UnitKerjaController::class, 'bulkToggleStatus'])->name('unit-kerja.bulk-toggle');
        Route::delete('/unit-kerja/bulk-delete', [\App\Http\Controllers\Master\UnitKerjaController::class, 'bulkDelete'])->name('unit-kerja.bulk-delete');
        Route::delete('/unit-kerja/{id}', [\App\Http\Controllers\Master\UnitKerjaController::class, 'destroy'])->name('unit-kerja.destroy');
    });

    // KEGIATAN
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

    // GALERI
    Route::middleware('can:foto.view')->group(function () {
        Route::get('/galeri', [\App\Http\Controllers\Kegiatan\GaleriController::class, 'index'])->name('galeri.index');
        Route::get('/galeri/getallpagination', [\App\Http\Controllers\Kegiatan\GaleriController::class, 'getAllPagination'])->name('galeri.getallpagination');
        Route::post('/galeri/download-zip', [\App\Http\Controllers\Kegiatan\GaleriController::class, 'downloadZip'])->name('galeri.download-zip');
        Route::delete('/galeri', [\App\Http\Controllers\Kegiatan\GaleriController::class, 'destroy'])->name('galeri.destroy');
    });

    Route::middleware('can:foto.upload')->group(function () {
        Route::post('/galeri/upload', [\App\Http\Controllers\Kegiatan\GaleriController::class, 'upload'])->name('galeri.upload');
    });

    // LAPORAN
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/bulanan', [LaporanController::class, 'bulanan'])->name('bulanan');
        Route::get('/export', [ExportController::class, 'index'])->name('export');
        Route::get('/export-pdf/preview', [ExportController::class, 'getPreview'])->name('export-pdf.preview');
        Route::get('/export-pdf/preview-full', [ExportController::class, 'previewFull'])->name('export-pdf.preview-full');
        Route::post('/export-pdf', [ExportController::class, 'store'])->name('export-pdf.store');
        Route::get('/export-pdf/{id}/download', [ExportController::class, 'download'])->name('export-pdf.download');
        Route::delete('/export-pdf/{id}', [ExportController::class, 'destroy'])->name('export-pdf.destroy');
    });

    // Profile (All authenticated users)
    Route::get('/profile', [\App\Http\Controllers\Master\ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [\App\Http\Controllers\Master\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [\App\Http\Controllers\Master\ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::post('/profile/avatar', [\App\Http\Controllers\Master\ProfileController::class, 'updateAvatar'])->name('profile.update-avatar');
    Route::post('/profile/cover', [\App\Http\Controllers\Master\ProfileController::class, 'updateCover'])->name('profile.update-cover');
    Route::get('/profile/activities', [\App\Http\Controllers\Master\ProfileController::class, 'getActivities'])->name('profile.activities');

    // System Setting
    Route::middleware('can:settings.view')->group(function () {
        Route::get('/setting/system', [\App\Http\Controllers\Master\SystemSettingController::class, 'index'])->name('setting.system.index');
        Route::post('/setting/system', [\App\Http\Controllers\Master\SystemSettingController::class, 'update'])->name('setting.system.update');
        Route::post('/setting/system/logo', [\App\Http\Controllers\Master\SystemSettingController::class, 'updateLogo'])->name('setting.system.update-logo');
        Route::post('/setting/system/test-email', [\App\Http\Controllers\Master\SystemSettingController::class, 'testEmail'])->name('setting.system.test-email');
        Route::get('/setting/security/stats', [\App\Http\Controllers\Master\SystemSettingController::class, 'getSecurityStats'])->name('setting.security.stats');
        Route::get('/setting/security/activities', [\App\Http\Controllers\Master\SystemSettingController::class, 'getActivityLogs'])->name('setting.security.activities');
        
        Route::get('/setting/activity-log', [\App\Http\Controllers\Master\ActivityLogController::class, 'index'])->name('setting.activity-log.index');
        Route::get('/setting/activity-log/getallpagination', [\App\Http\Controllers\Master\ActivityLogController::class, 'getAllPagination'])->name('setting.activity-log.getallpagination');
        Route::get('/setting/activity-log/{id}', [\App\Http\Controllers\Master\ActivityLogController::class, 'show'])->name('setting.activity-log.show');
        Route::delete('/setting/activity-log/{id}', [\App\Http\Controllers\Master\ActivityLogController::class, 'destroy'])->name('setting.activity-log.destroy');
    });

    // Role Permission Routes
    Route::middleware('can:settings.role')->group(function () {
        Route::get('/setting/role-permission', [\App\Http\Controllers\Shield\RolePermissionController::class, 'index'])->name('setting.role-permission.index');
        Route::post('/setting/role-permission', [\App\Http\Controllers\Shield\RolePermissionController::class, 'store'])->name('setting.role-permission.store');
        Route::put('/setting/role-permission/{role_permission}', [\App\Http\Controllers\Shield\RolePermissionController::class, 'update'])->name('setting.role-permission.update');
        Route::delete('/setting/role-permission/{role_permission}', [\App\Http\Controllers\Shield\RolePermissionController::class, 'destroy'])->name('setting.role-permission.destroy');
        Route::post('/setting/role-permission/sync', [\App\Http\Controllers\Shield\RolePermissionController::class, 'syncPermissions'])->name('setting.role-permission.sync');
    });

    // Backup Routes
    Route::get('/setting/backup', [\App\Http\Controllers\Master\BackupController::class, 'index'])->name('setting.backup.index');
    Route::post('/setting/backup', [\App\Http\Controllers\Master\BackupController::class, 'create'])->name('setting.backup.create');
    Route::get('/setting/backup/download/{id}', [\App\Http\Controllers\Master\BackupController::class, 'download'])->name('setting.backup.download');
    Route::delete('/setting/backup/{id}', [\App\Http\Controllers\Master\BackupController::class, 'delete'])->name('setting.backup.delete');
});

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/profile-default', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile-default', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update-default');
    Route::delete('/profile-default', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
