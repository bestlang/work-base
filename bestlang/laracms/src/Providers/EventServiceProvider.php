<?php
namespace BestLang\Laracms\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use BestLang\Laracms\Events\PayNotify;
use BestLang\Laracms\Listeners\PayNotifyProcess;

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