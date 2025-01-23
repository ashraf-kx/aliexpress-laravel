<?php

namespace Shacz\AliExpressSDK;

use Illuminate\Support\ServiceProvider;

class AliExpressSDKServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->offerPublishing();
    }

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

    protected function offerPublishing()
    {
        if (! function_exists('config_path')) {
            // function not available and 'publish' not relevant in Lumen
            return;
        }

        $this->publishes([
            __DIR__.'/../config/aliexpress.php' => config_path('aliexpress.php'),
        ], 'aliexpress-config');

        // $this->publishes([
        //     __DIR__.'/../database/migrations/create_permission_tables.php.stub' => $this->getMigrationFileName('create_permission_tables.php'),
        // ], 'permission-migrations');
    }

    protected function registerCommands()
    {
        $this->commands([
            // Commands\CacheReset::class,
            // Commands\CreateRole::class,
            // Commands\CreatePermission::class,
            // Commands\Show::class,
            // Commands\UpgradeForTeams::class,
        ]);
    }

    protected function registerModelBindings()
    {
        // $config = $this->app->config['permission.models'];

        // if (! $config) {
        //     return;
        // }

        // $this->app->bind(PermissionContract::class, $config['permission']);
        // $this->app->bind(RoleContract::class, $config['role']);
    }
}
