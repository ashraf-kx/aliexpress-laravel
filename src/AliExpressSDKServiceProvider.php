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
        // Publish the configuration file
        $this->publishes([
            __DIR__ . '/../config/aliexpress.php' => config_path('aliexpress.php'),
        ], 'config');

        // Automatically publish the configuration file if it doesn't exist
        if ($this->app->runningInConsole()) {
            $this->autoPublish();
        }
    }

        /**
     * Auto-publish assets if not already published.
     */
    protected function autoPublish()
    {
        $configFile = config_path('aliexpress.php');

        if (!file_exists($configFile)) {
            $this->publishes([
                __DIR__ . '/../config/aliexpress.php' => $configFile,
            ], 'config');

            // Optionally log or output that the file was published
            $this->commands([
                function () {
                    $this->info('AliExpressSDK configuration file has been published.');
                },
            ]);
        }
    }
}
