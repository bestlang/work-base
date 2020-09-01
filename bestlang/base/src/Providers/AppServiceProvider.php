<?php

namespace Bestlang\Base\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        $this->app['router']->aliasMiddleware('auth.jwt', \Tymon\JWTAuth\Http\Middleware\Authenticate::class);
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
//            if($user->hasRole('administrator')){
//                $permissions = Permission::all();
//                foreach ($permissions as $permission){
//                    $user->givePermissionTo($permission->name);
//                }
//                return true;
//            }else{
//                return null;
//            }
        });
        // config
        $this->publishes([
            __DIR__.'/../../config/auth.php' => config_path('auth.php'),
            __DIR__.'/../../config/jwt.php' => config_path('jwt.php'),
            //__DIR__.'/../../config/ueditor.php' => config_path('ueditor.php'),
            __DIR__.'/../../config/permission.php' => config_path('permission.php'),
        ], 'bestlang-base-config');

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

        Blade::directive('channelLink', function ($expression) {
            @list($channelName, $channelId, $as) = explode('-', $expression);
            if($as){
                $channelName = $as;
            }
            return "<a href=\"".route('channel', $channelId)."\">".$channelName."</a>";
        });

    }
}
