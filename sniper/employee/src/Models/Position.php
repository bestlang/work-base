<?php

namespace Sniper\Employee\Models;

use Baum\Node;
use BestLang\Base\Events\ModelCreatedEvent;
use BestLang\Base\Events\ModelDeletedEvent;
use BestLang\Base\Events\ModelUpdatedEvent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sniper\Employee\Models\Competence\PositionAbilityCategory;

class Position extends Node
{
    use SoftDeletes;
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

    public function abilityCategories()
    {
        return $this->hasMany(PositionAbilityCategory::class, 'position_id', 'id');
    }
}
