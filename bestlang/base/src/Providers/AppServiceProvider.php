<?php

namespace Bestlang\Base\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Tymon\JWTAuth\Http\Middleware\Authenticate;
use Bestlang\Base\Exceptions\Handler as CustomExceptionHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['router']->aliasMiddleware('auth.jwt', Authenticate::class);
        $this->app->singleton(
            ExceptionHandler::class,
            CustomExceptionHandler::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::before(function ($user, $ability) {
            foreach ($user->getPermissionsViaRoles() as $permission){
                $user->givePermissionTo($permission->name);
            }
            /*if($user->hasRole('administrator')){
                $permissions = Permission::all();
                foreach ($permissions as $permission){
                    $user->givePermissionTo($permission->name);
                }
                return true;
            }else{
                return null;
            }*/
        });
        // migrations
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->loadViewsFrom(__DIR__.'/../../resources/views/base', 'base');
        // config
        $this->publishes([
            __DIR__.'/../../config/auth.php' => config_path('auth.php'),
            __DIR__.'/../../config/jwt.php' => config_path('jwt.php'),
            __DIR__.'/../../config/permission.php' => config_path('permission.php'),
        ], 'bestlang-base-config');

        // vue 后台代码
//        $this->publishes([
//            __DIR__.'/../../resources/admin/' => resource_path('admin')
//        ], 'admin');
    }
}
