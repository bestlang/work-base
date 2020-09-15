<?php

namespace Sniper\Employee\Models;

use Baum\Node;

class Department extends Node
{
    protected $table = 'sniper_employee_ding_attendance';
    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(Attendance::class, 'parent_id');
    }
}
