<?php

namespace HostMyServers\NetimRestApi;

use Illuminate\Support\ServiceProvider;

class NetimServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publication de la configuration
        $this->publishes([
            __DIR__ . '/../config/netim.php' => config_path('netim.php'),
        ], 'netim-config');
    }

    public function register()
    {
        // Fusion de la configuration
        $this->mergeConfigFrom(
            __DIR__ . '/../config/netim.php',
            'netim'
        );

        // Enregistrement du singleton
        $this->app->singleton(NetimClient::class, function ($app) {
            return new NetimClient();
        });
    }
}
