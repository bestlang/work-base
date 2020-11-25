<?php

namespace BestLang\LaraCms\Providers;

use Illuminate\Support\ServiceProvider;
use BestLang\LaraCms\Console\Commands\LaraCms;
//use Illuminate\Support\Facades\Gate;
//use BestLang\LaraCms\Models\Permission;

use BestLang\LaraCms\Models\Cms\Order;
use BestLang\LaraCms\Observers\Cms\OrderObserver;
use Blade;
use BestLang\WxPay\Pay\Contracts\OrderInterface as WxPayOrderInterface;
use Alipay\EasySDK\Contracts\OrderInterface as AlipayOrderInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('laracms', 'BestLang\LaraCms\LaraCms');
        $this->app->singleton(
            WxPayOrderInterface::class,
            Order::class
        );
        $this->app->singleton(
            AlipayOrderInterface::class,
            Order::class
        );
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
            $this->commands([
                LaraCms::class
            ]);
            // config
            $this->publishes([
                __DIR__.'/../../config/ueditor.php' => config_path('ueditor.php'),
            ], 'laracms-config');
            // migrations
            $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
            // seeder
            $this->publishes([
                __DIR__ . '/../../database/seeds' => database_path('seeds/')
            ], 'laracms-seeds');
            // static file
            $this->publishes([
                __DIR__ . '/../../resources/assets/dark/front.css' => public_path('vendor/laracms/dark/front.css'),
                __DIR__ . '/../../resources/assets/dark/images/' => public_path('vendor/laracms/dark/images/')
            ], 'laracms-assets');
        }
        $this->loadViewsFrom(__DIR__.'/../../resources/views/laracms', 'laracms');

        Blade::directive('channelLink', function ($expression) {
            $expression = strval($expression);
            @list($channelName, $channelId, $as) = explode('-', $expression);
            if($as){
                $channelName = $as;
            }
            return "<a href=\"".route('channel', $channelId)."\">".$channelName."</a>";
        });

    }
}
