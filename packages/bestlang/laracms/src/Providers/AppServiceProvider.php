<?php

namespace Bestlang\Laracms\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/jwt.php' => config_path('jwt.php'),
            __DIR__.'/../../config/ueditor.php' => config_path('ueditor.php'),
        ], 'config');

        // vue 后台代码
        $this->publishes([
            __DIR__.'/../../resources/admin/' => resource_path('vendor/laracms/admin/')
        ], 'admin');

        $this->loadViewsFrom(__DIR__.'../../resources/views/laracms', 'laracms');
    }
}
