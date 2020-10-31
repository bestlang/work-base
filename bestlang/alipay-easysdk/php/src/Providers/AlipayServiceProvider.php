<?php
namespace Alipay\EasySDK\Providers;

use Illuminate\Support\ServiceProvider;

class AlipayServiceProvider extends ServiceProvider{

    public function register()
    {

    }

    public function boot()
    {
        if ($this->app->runningInConsole()){
            // config
            $this->publishes([
                __DIR__.'/../../config/alipay.php' => config_path('alipay.php'),
            ], 'alipay-config');
        }
    }
}