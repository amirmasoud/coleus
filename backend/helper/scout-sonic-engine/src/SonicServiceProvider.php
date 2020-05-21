<?php

namespace Coleus\Sonic\Providers;

use Coleus\Sonic\SonicEngine;
use SonicSearch\ChannelFactory;
use Laravel\Scout\EngineManager;
use Illuminate\Support\ServiceProvider;

class SonicServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/sonic.php' => config_path('sonic.php'),
        ], 'config');

        $this->app->make(EngineManager::class)->extend('sonic', function () {
            $factory = new ChannelFactory(
                config('scout.sonic.address'),
                config('scout.sonic.port'),
                config('scout.sonic.password'),
                config('scout.sonic.connection_timeout'),
                config('scout.sonic.read_timeout')
            );

            return new SonicEngine($factory);
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/sonic.php', 'sonic');
    }
}
