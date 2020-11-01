<?php
namespace BestLang\WxPay;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use BestLang\WxPay\Events\PayNotify;
use BestLang\WxPay\Listeners\PayNotifyProcess;

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