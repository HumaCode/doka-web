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
        $this->app->bind(\App\Repositories\Master\Pengguna\UserRepositoryInterface::class, \App\Repositories\Master\Pengguna\UserRepository::class);
        $this->app->bind(\App\Services\Master\Pengguna\UserServiceInterface::class, \App\Services\Master\Pengguna\UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
