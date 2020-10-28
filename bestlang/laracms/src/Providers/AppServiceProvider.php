<?php

namespace BestLang\Laracms\Providers;

use Illuminate\Support\ServiceProvider;
//use Illuminate\Support\Facades\Gate;
//use BestLang\Laracms\Models\Permission;

use BestLang\Laracms\Models\Cms\Order;
use BestLang\Laracms\Observers\Cms\OrderObserver;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('laracms', 'BestLang\Laracms\Laracms');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Order::observe(OrderObserver::class);
        if ($this->app->runningInConsole()) {
            // config
            $this->publishes([
                __DIR__.'/../../config/ueditor.php' => config_path('ueditor.php'),
            ], 'laracms-config');
            // migrations
            $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
            // seeder
//            $this->publishes([
//                __DIR__ . '/../../database/seeds/InitTableSeeder.php' => database_path('seeds/InitTableSeeder.php')
//            ], 'laracms-seeds');
        }
        $this->loadViewsFrom(__DIR__.'/../../resources/views/laracms', 'laracms');

        Blade::directive('channelLink', function ($expression) {
            @list($channelName, $channelId, $as) = explode('-', $expression);
            if($as){
                $channelName = $as;
            }
            return "<a href=\"".route('channel', $channelId)."\">".$channelName."</a>";
        });

    }
}
