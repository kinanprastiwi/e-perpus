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
        // Manual register controller jika perlu
        $this->app->bind('PetugasDashboard', function() {
            return new \App\Http\Controllers\Petugas\PetugasDashboardController();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Manual register middleware
        $this->app['router']->aliasMiddleware('role', \App\Http\Middleware\CheckRole::class);
        
        // Tambahan konfigurasi lainnya jika perlu
    }
}