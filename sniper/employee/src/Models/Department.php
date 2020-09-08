<?php

namespace Sniper\Employee\Models;

use Baum\Node;

class Department extends Node
{
    protected $table = 'sniper_employee_departments';
    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }
}
