<?php

namespace BestLang\LaraCMS\Providers;

use BestLang\Base\Models\HashConfig;
use Illuminate\Support\ServiceProvider;
use BestLang\LaraCMS\Console\Commands\LaraCMS;
//use Illuminate\Support\Facades\Gate;
//use BestLang\LaraCMS\Models\Permission;

use BestLang\LaraCMS\Models\Cms\Order;
use BestLang\LaraCMS\Observers\Cms\OrderObserver;
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
        $this->app->bind('laracms', 'BestLang\LaraCMS\LaraCMS');
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
                LaraCMS::class
            ]);
            // config
            $this->publishes([
                __DIR__.'/../../config/ueditor.php' => config_path('ueditor.php'),
            ], 'laracms-config');
            // migrations
            $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
            // static file
            $this->publishes([
                __DIR__ . '/../../resources/assets/dark/front.css' => public_path('vendor/laracms/dark/front.css'),
                __DIR__ . '/../../resources/assets/dark/images/' => public_path('vendor/laracms/dark/images/')
            ], 'laracms-assets');
        }
        $this->loadViewsFrom(__DIR__.'/../../resources/views/laracms', 'LaraCMS');

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
