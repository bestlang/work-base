<?php

namespace Bestlang\Laracms\Providers;

use Illuminate\Support\ServiceProvider;
use Bestlang\Laracms\Laracms;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('laracms', function ($app) {
            return new Laracms();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // config
        $this->publishes([
            __DIR__.'/../../config/jwt.php' => config_path('jwt.php'),
            __DIR__.'/../../config/ueditor.php' => config_path('ueditor.php'),
        ], 'config');

        // vue 后台代码
        $this->publishes([
            __DIR__.'/../../resources/admin/' => resource_path('admin')
        ], 'admin');

        // static file
        $this->publishes([
            __DIR__ . '/../../resources/laracms_static/' => public_path('laracms_static')
        ], 'static');

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        // migrations
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->loadViewsFrom(__DIR__.'/../../resources/views/laracms', 'laracms');

        // views
        $this->publishes([
            __DIR__.'/../../resources/views/laracms' => resource_path('views/vendor/laracms')
        ], 'views');
    }
}
