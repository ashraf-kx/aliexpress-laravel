<?php

namespace Shacz\AliExpressSDK;

use Illuminate\Support\ServiceProvider;

class AliExpressSDKServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/aliexpress.php',
            'aliexpress'
        );

        // Bind the AliExpress client
        $this->app->singleton(IopClient::class, function ($app) {
            return new IopClient(
                config('aliexpress.app_key'),
                config('aliexpress.secret_key'),
                config('aliexpress.gateway_url')
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Publish configuration
        $this->publishes([
            __DIR__ . '/../config/aliexpress.php' => config_path('aliexpress.php'),
        ]);
    }
}
