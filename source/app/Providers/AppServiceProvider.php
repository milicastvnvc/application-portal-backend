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
        $this->app->register(
            provider: ResponseServiceProvider::class,
        );

        $this->app->register(
            provider: RepositoryServiceProvider::class,
        );

        $this->app->register(
            provider: ServiceLayerServiceProvider::class,
        );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
