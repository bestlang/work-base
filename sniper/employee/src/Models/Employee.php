<?php

namespace Sniper\Employee\Models;

use Baum\Node;

class Employee extends Node
{
    protected $table = 'sniper_employee_employee';

    // 'parent_id' column name
    protected $parentColumn = 'parent_user_id';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
