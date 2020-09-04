<?php

namespace Bestlang\Laracms\Providers;

use Illuminate\Support\ServiceProvider;
//use Illuminate\Support\Facades\Gate;
//use Bestlang\Laracms\Models\Permission;

use Bestlang\Laracms\Models\Cms\Order;
use Bestlang\Laracms\Observers\Cms\OrderObserver;
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
        $this->app->bind('laracms', 'Bestlang\Laracms\Laracms');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Order::observe(OrderObserver::class);
        // config
        $this->publishes([
            __DIR__.'/../../config/ueditor.php' => config_path('ueditor.php'),
        ], 'laracms-config');

        // static file
        $this->publishes([
            __DIR__ . '/../../resources/vendor/' => public_path('vendor/')
        ], 'laracms-static');

        // migrations
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        // seeder
        $this->publishes([
            __DIR__ . '/../../database/seeds/InitTableSeeder.php' => database_path('seeds/InitTableSeeder.php')
        ], 'laracms-seeds');

        $this->loadViewsFrom(__DIR__.'/../../resources/views/laracms', 'laracms');

        // views
        $this->publishes([
            __DIR__.'/../../resources/views/laracms' => resource_path('views/vendor/laracms')
        ], 'laracms-views');

        Blade::directive('channelLink', function ($expression) {
            @list($channelName, $channelId, $as) = explode('-', $expression);
            if($as){
                $channelName = $as;
            }
            return "<a href=\"".route('channel', $channelId)."\">".$channelName."</a>";
        });

    }
}
