<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Kegiatan\Kegiatan;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Pengguna
        $this->app->bind(\App\Repositories\Master\Pengguna\UserRepositoryInterface::class, \App\Repositories\Master\Pengguna\UserRepository::class);
        $this->app->bind(\App\Services\Master\Pengguna\UserServiceInterface::class, \App\Services\Master\Pengguna\UserService::class);

        // Kategori
        $this->app->bind(\App\Repositories\Master\Kategori\CategoryRepositoryInterface::class, \App\Repositories\Master\Kategori\CategoryRepository::class);
        $this->app->bind(\App\Services\Master\Kategori\CategoryServiceInterface::class, \App\Services\Master\Kategori\CategoryService::class);

        // Unit Kerja
        $this->app->bind(\App\Repositories\Master\UnitKerja\UnitKerjaRepositoryInterface::class, \App\Repositories\Master\UnitKerja\UnitKerjaRepository::class);
        $this->app->bind(\App\Services\Master\UnitKerja\UnitKerjaServiceInterface::class, \App\Services\Master\UnitKerja\UnitKerjaService::class);

        // Kegiatan
        $this->app->bind(\App\Repositories\Kegiatan\KegiatanRepositoryInterface::class, \App\Repositories\Kegiatan\KegiatanRepository::class);
        $this->app->bind(\App\Services\Kegiatan\KegiatanServiceInterface::class, \App\Services\Kegiatan\KegiatanService::class);

        // Galeri
        $this->app->bind(\App\Repositories\Kegiatan\GaleriRepositoryInterface::class, \App\Repositories\Kegiatan\GaleriRepository::class);
        $this->app->bind(\App\Services\Kegiatan\GaleriServiceInterface::class, \App\Services\Kegiatan\GaleriService::class);

        // Laporan
        $this->app->bind(\App\Repositories\Laporan\LaporanRepositoryInterface::class, \App\Repositories\Laporan\LaporanRepository::class);
        $this->app->bind(\App\Services\Laporan\LaporanServiceInterface::class, \App\Services\Laporan\LaporanService::class);

        // Export
        $this->app->bind(\App\Repositories\Laporan\ExportRepositoryInterface::class, \App\Repositories\Laporan\ExportRepository::class);
        $this->app->bind(\App\Services\Laporan\ExportServiceInterface::class, \App\Services\Laporan\ExportService::class);

        // Profile
        $this->app->bind(\App\Repositories\Master\Profile\ProfileRepositoryInterface::class, \App\Repositories\Master\Profile\ProfileRepository::class);
        $this->app->bind(\App\Services\Master\Profile\ProfileServiceInterface::class, \App\Services\Master\Profile\ProfileService::class);

        // System Setting
        $this->app->bind(\App\Repositories\Master\SystemSetting\SystemSettingRepositoryInterface::class, \App\Repositories\Master\SystemSetting\SystemSettingRepository::class);
        $this->app->bind(\App\Services\Master\SystemSetting\SystemSettingServiceInterface::class, \App\Services\Master\SystemSetting\SystemSettingService::class);

        // Activity Log
        $this->app->bind(\App\Repositories\Master\ActivityLog\ActivityLogRepositoryInterface::class, \App\Repositories\Master\ActivityLog\ActivityLogRepository::class);
        $this->app->bind(\App\Services\Master\ActivityLog\ActivityLogServiceInterface::class, \App\Services\Master\ActivityLog\ActivityLogService::class);

        // Backup
        $this->app->bind(\App\Repositories\Master\Backup\BackupRepositoryInterface::class, \App\Repositories\Master\Backup\BackupRepository::class);
        $this->app->bind(\App\Services\Master\Backup\BackupServiceInterface::class, \App\Services\Master\Backup\BackupService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Handle Dynamic System Settings
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('system_settings')) {
                $settings = \Illuminate\Support\Facades\Cache::remember('system_settings_config', 3600, function() {
                    return \App\Models\Master\SystemSetting::all()->pluck('value', 'key')->toArray();
                });

                // 1. Activity Log
                if (isset($settings['activity_log_enabled']) && $settings['activity_log_enabled'] === '0') {
                    config(['activitylog.enabled' => false]);
                }

                // 2. SMTP Configuration
                if (isset($settings['mail_host']) && !empty($settings['mail_host'])) {
                    config([
                        'mail.default' => $settings['mail_mailer'] ?? 'smtp',
                        'mail.mailers.smtp.host' => $settings['mail_host'],
                        'mail.mailers.smtp.port' => (int)($settings['mail_port'] ?? 587),
                        'mail.mailers.smtp.encryption' => $settings['mail_encryption'] ?? 'tls',
                        'mail.mailers.smtp.username' => $settings['mail_username'] ?? '',
                        'mail.mailers.smtp.password' => $settings['mail_password'] ?? '',
                        'mail.from.address' => $settings['mail_from_address'] ?? config('mail.from.address'),
                        'mail.from.name' => $settings['mail_from_name'] ?? config('mail.from.name'),
                    ]);
                }

                // 3. App Settings
                if (isset($settings['app_name'])) {
                    config(['app.name' => $settings['app_name']]);
                }
            }
        } catch (\Exception $e) {
            // Table might not exist yet during migration
        }

        View::composer('layouts.partials.sidebar', function ($view) {
            $newUserCount = 0;
            $newKegiatanCount = 0;

            if (auth()->check()) {
                $user = auth()->user();
                $isDev = $user->hasRole('dev');
                $fiveDaysAgo = now()->subDays(5);

                // Count new users in last 5 days
                $userQuery = User::where('created_at', '>=', $fiveDaysAgo);
                if (!$isDev) {
                    $userQuery->where('unit_kerja_id', $user->unit_kerja_id);
                }
                $newUserCount = $userQuery->count();

                // Count new activities in last 5 days
                $kegiatanQuery = Kegiatan::where('created_at', '>=', $fiveDaysAgo);
                if (!$isDev) {
                    $kegiatanQuery->where('unit_id', $user->unit_kerja_id);
                }
                $newKegiatanCount = $kegiatanQuery->count();
            }

            $view->with([
                'sidebarNewUserCount' => $newUserCount,
                'sidebarNewKegiatanCount' => $newKegiatanCount,
            ]);
        });
    }
}
