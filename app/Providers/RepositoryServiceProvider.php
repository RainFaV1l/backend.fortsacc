<?php

namespace App\Providers;

use App\Repositories\Interfaces\MysteryBoxInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\MysteryBoxRepository;
use App\Repositories\OrderRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class,
        );
        $this->app->bind(
            MysteryBoxInterface::class,
            MysteryBoxRepository::class,
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
