<?php
namespace BestLang\Base\Listeners;

use BestLang\Base\Events\HistoryEvent;

class HistoryEventListener
{
    public function __construct()
    {
        //
    }

    public function handle(HistoryEvent $event)
    {
        $history = $event->history;
        $history->user_id = auth()->user()->id;
        $history->ip = request()->ip();
        $history->save();
    }
}