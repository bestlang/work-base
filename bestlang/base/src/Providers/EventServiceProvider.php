<?php
namespace BestLang\Base\Providers;

use BestLang\Base\Events\ModelCreatedEvent;
use BestLang\Base\Events\ModelDeletedEvent;
use BestLang\Base\Events\ModelUpdatedEvent;
use BestLang\Base\Listeners\ModelCreatedListener;
use BestLang\Base\Listeners\ModelDeletedListener;
use BestLang\Base\Listeners\ModelUpdatedListener;
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
        ModelCreatedEvent::class => [
            ModelCreatedListener::class
        ],
        ModelDeletedEvent::class => [
            ModelDeletedListener::class
        ],
        ModelUpdatedEvent::class => [
            ModelUpdatedListener::class
        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            'SocialiteProviders\QQ\QqExtendSocialite@handle',
        ]
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