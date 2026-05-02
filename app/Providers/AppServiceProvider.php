<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        //
    }
}
