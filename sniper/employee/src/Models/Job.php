<?php

namespace Sniper\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use BestLang\Base\Events\ModelCreatedEvent;
use BestLang\Base\Events\ModelDeletedEvent;
use BestLang\Base\Events\ModelUpdatedEvent;

class Job extends Model
{
    protected $table = 'sniper_employee_jobs';

    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => ModelCreatedEvent::class,
        'deleted' => ModelDeletedEvent::class,
        'updated' => ModelUpdatedEvent::class
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'user_id', 'user_id');
    }
}