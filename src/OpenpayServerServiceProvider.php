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

            //Define the files which are going to be published
            $this->publishes([
                __DIR__.'/migrations/2015_11_19_000000_create_openpay_reference_table.php'=>base_path('database/migrations/2015_11_19_000000_create_openpay_reference_table.php')]
            );
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
