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
        // Mengikat interface ke implementasi
        // $this->app->bind(
        //     'App\Interfaces\ExampleInterface',
        //     'App\Repositories\ExampleRepository'
        // );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Mengatur locale aplikasi
        // app()->setLocale('id');

        // Mengatur default string length untuk migration
        // Schema::defaultStringLength(191);
    }
}