<?php
namespace Sniper\Employee\Providers;

use Illuminate\Support\ServiceProvider;
use Sniper\Employee\Console\Commands\DingTalk;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/database.php', 'database.connections'
        );
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
            $this->commands([
                DingTalk::class
            ]);
            $this->publishes([
                __DIR__.'/../../config/ding.php' => config_path('ding.php'),
            ], 'sniper-config');
            // static file
            $this->publishes([
                __DIR__ . '/../../resources/assets/front.css' => public_path('vendor/sniper/front.css'),
                __DIR__ . '/../../resources/assets/images/' => public_path('vendor/sniper/images/')
            ], 'sniper-assets');
        }
        $this->loadViewsFrom(__DIR__.'/../../resources/views/sniper', 'sniper');
    }
}
