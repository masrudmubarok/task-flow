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
        // app()->setLocale('id');

        // Schema::defaultStringLength(191);
    }
}