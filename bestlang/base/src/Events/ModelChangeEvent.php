<?php

namespace BestLang\Base\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;

class ModelChangeEvent
{
    public $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}