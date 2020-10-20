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
        //登录注册模板命名空间
        session(['authViewNamespace'=>'sniper']);

        if ($this->app->runningInConsole()) {
            $this->commands([
                DingTalk::class
            ]);
            $this->publishes([
                __DIR__.'/../../config/ding.php' => config_path('ding.php'),
            ], 'sniper-config');
        }
        $this->loadViewsFrom(__DIR__.'/../../resources/views/sniper', 'sniper');
    }
}
