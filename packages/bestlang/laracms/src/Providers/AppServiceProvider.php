<?php

namespace Bestlang\Laracms\Providers;

use Illuminate\Support\ServiceProvider;
//use Bestlang\Laracms\LC;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('lc', 'Bestlang\Laracms\LC');
        $this->app['router']->aliasMiddleware('auth.jwt', \Tymon\JWTAuth\Http\Middleware\Authenticate::class);
        $this->app->singleton(
            Illuminate\Contracts\Debug\ExceptionHandler::class,
            Bestlang\Laracms\Exceptions\Handler::class
        );
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
            __DIR__.'/../../config/permission.php' => config_path('permission.php'),
        ], 'config');

        // vue 后台代码
        $this->publishes([
            __DIR__.'/../../resources/admin/' => resource_path('admin')
        ], 'admin');

        // static file
        $this->publishes([
            __DIR__ . '/../../resources/laracms_static/' => public_path('laracms_static')
        ], 'static');

        // migrations
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->loadViewsFrom(__DIR__.'/../../resources/views/laracms', 'laracms');

        // views
        $this->publishes([
            __DIR__.'/../../resources/views/laracms' => resource_path('views/vendor/laracms')
        ], 'views');
    }
}
