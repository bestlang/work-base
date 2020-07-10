<?php

namespace Bestlang\Laracms\Providers;

use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
//use Bestlang\Laracms\LC;
use Illuminate\Support\Facades\Gate;
use Bestlang\Laracms\Models\Permission;

use Bestlang\Laracms\Models\Cms\Order;
use Bestlang\Laracms\Observers\Cms\OrderObserver;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Order::observe(OrderObserver::class);

        //下面代码在每个请求周期中都会重复执行,影响效率, 可以改成登录的时候做一次
        Gate::before(function ($user, $ability) {
            foreach ($user->getPermissionsViaRoles() as $permission){
                $user->givePermissionTo($permission->name);
            }
            if($user->hasRole('administrator')){
                $permissions = Permission::all();
                foreach ($permissions as $permission){
                    $user->givePermissionTo($permission->name);
                }
                return true;
            }else{
                return null;
            }
        });
        // config
        $this->publishes([
            __DIR__.'/../../config/auth.php' => config_path('auth.php'),
            __DIR__.'/../../config/jwt.php' => config_path('jwt.php'),
            __DIR__.'/../../config/ueditor.php' => config_path('ueditor.php'),
            __DIR__.'/../../config/permission.php' => config_path('permission.php'),
        ], 'laracms-config');

        // vue 后台代码
//        $this->publishes([
//            __DIR__.'/../../resources/admin/' => resource_path('admin')
//        ], 'admin');

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
    }
}
