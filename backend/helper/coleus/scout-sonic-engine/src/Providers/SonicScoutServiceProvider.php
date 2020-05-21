<?php

namespace coleus\Sonic\Providers;

use Illuminate\Support\ServiceProvider;
use coleus\Sonic\Engines\SonicSearchEngine;
use Laravel\Scout\EngineManager;
use SonicSearch\ChannelFactory;

class SonicServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->make(EngineManager::class)->extend('sonic', function () {
            $factory = new ChannelFactory(
                config('scout.sonic.address'),
                config('scout.sonic.port'),
                config('scout.sonic.password'),
                config('scout.sonic.connection_timeout'),
                config('scout.sonic.read_timeout')
            );

            return new SonicSearchEngine($factory);
        });
    }
}
