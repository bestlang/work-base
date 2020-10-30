<?php
namespace BestLang\Base\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use BestLang\Base\Events\HistoryEvent;
use BestLang\Base\Listeners\HistoryEventListener;

class EventServiceProvider extends ServiceProvider{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        HistoryEvent::class => [
            HistoryEventListener::class,
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