<?php

namespace Sniper\Employee\Models;

use Baum\Node;
use BestLang\Base\Events\ModelCreatedEvent;
use BestLang\Base\Events\ModelDeletedEvent;
use BestLang\Base\Events\ModelUpdatedEvent;

class Position extends Node
{
    protected $table = 'sniper_employee_positions';
    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => ModelCreatedEvent::class,
        'deleted' => ModelDeletedEvent::class,
        'updated' => ModelUpdatedEvent::class
    ];


    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function parent()
    {
        return $this->belongsTo(Position::class, 'parent_id');
    }

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}
