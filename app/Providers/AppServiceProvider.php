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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
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
