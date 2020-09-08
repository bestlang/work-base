<?php

namespace Sniper\Employee\Models;

use Baum\Node;

class Position extends Node
{
    protected $table = 'sniper_employee_positions';
    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(Position::class, 'parent_id');
    }
}
