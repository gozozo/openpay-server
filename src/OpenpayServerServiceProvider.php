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
        if (! $this->app->routesAreCached()) {
            require __DIR__ . '/Http/routes.php';
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('openpay-server',function ($app){
            return new OpenpayServer;
        });
    }
}
