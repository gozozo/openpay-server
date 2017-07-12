<?php

namespace Gozozo\OpenpayServer;

use Illuminate\Support\ServiceProvider;

class OpenpayServerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom (__DIR__ . '/Http/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->publishes([
            __DIR__ . '/config/openpay.php' => config_path('openpay.php')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\OpenpayServer::class, function ($app) {
            return new OpenpayServer;
        });
    }
}
