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
            // seeder
            $this->publishes([
                __DIR__ . '/../../database/seeds' => database_path('seeds/')
            ], 'sniper-seeds');
        }
        $this->loadViewsFrom(__DIR__.'/../../resources/views/sniper', 'sniper');
    }
}
