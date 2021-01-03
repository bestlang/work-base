<?php
namespace BestLang\Base\Listeners;

use BestLang\Base\Events\ModelDeletedEvent;
use BestLang\Base\Models\History;

class ModelDeletedListener
{
    public function __construct()
    {
        //
    }

    public function handle(ModelDeletedEvent $event)
    {
        $history = new History();
        $history->action = '数据库-删除';
        $model = $event->model;
        $ref = new \ReflectionClass($model);
        $history->detail = $ref->getName().'|::|'.($model->id ? $model->id : '').'|::|'.json_encode($event->model->toArray());
        $history->user_id = auth()->user() ? auth()->user()->id : 0;
        $history->ip = request()->ip();
        $history->save();
    }
}