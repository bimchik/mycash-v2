<?php

namespace App\Providers;

use App\Repositories\BallanceTypeRepository;
use App\Repositories\Interfaces\BallanceTypeInterface;
use App\Repositories\Interfaces\SpendingsInterface;
use App\Repositories\SpendingsRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            SpendingsInterface::class,
            SpendingsRepository::class
        );

        $this->app->bind(
            BallanceTypeInterface::class,
            BallanceTypeRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
