<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\ICallRepository;
use App\Repositories\Implementations\CallRepository;

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

        $this->app->bind(ICallRepository::class, CallRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
