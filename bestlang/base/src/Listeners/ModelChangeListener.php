<?php
namespace BestLang\Base\Listeners;

use BestLang\Base\Events\ModelChangeEvent;
use BestLang\Base\Models\History;

class ModelChangeListener
{
    public function __construct()
    {
        //
    }

    public function handle(ModelChangeEvent $event)
    {
        $history = new History();
        $history->action = 'DB Change';
        $history->detail = json_encode($event->model->toArray());
        $history->user_id = auth()->user()->id;
        $history->ip = request()->ip();
        $history->save();
    }
}