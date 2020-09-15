<?php

namespace Sniper\Employee\Models;

use Baum\Node;

class Position extends Node
{
    protected $table = 'sniper_employee_positions';
    protected $guarded = [];

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
