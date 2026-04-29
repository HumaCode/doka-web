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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
