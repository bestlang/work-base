<?php
namespace Sniper\Employee\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {

    }

    public function boot()
    {
        //写入项目信息
        session(['project'=>'sniper'], 'base');
        $this->loadViewsFrom(resource_path('views/vendor/sniper'), 'sniper');

    }
}
