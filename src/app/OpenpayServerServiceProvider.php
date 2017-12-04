<?php

namespace Gozozo\OpenpayServer;

use Illuminate\Support\ServiceProvider;
use OpenpayApi;

class OpenpayServerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom (__DIR__ . '/../app/Http/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'openpay');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'openpay');
        $this->publishes([
            __DIR__ . '/../config/openpay.php' => config_path('openpay.php')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(OpenpayApi::class, function ($app) {
            \Openpay::setProductionMode(!config('openpay.sandbox'));
            return \Openpay::getInstance(config('openpay.id'), config('openpay.sk'));
        });
    }
}
