<?php

namespace Jsdecena\Bridge;

use Illuminate\Support\ServiceProvider;

class BridgeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'bridge');

        $this->publishes([
            __DIR__ . '/database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/config/bridge.php' => config_path('bridge.php')
        ], 'config');

        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/routes.php';
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
    }
}
