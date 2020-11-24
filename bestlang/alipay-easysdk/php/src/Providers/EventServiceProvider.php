<?php
namespace Alipay\EasySDK\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Alipay\EasySDK\Events\PayNotify;
use Alipay\EasySDK\Listeners\PayNotifyProcess;

class EventServiceProvider extends ServiceProvider{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        PayNotify::class => [
            PayNotifyProcess::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }
}