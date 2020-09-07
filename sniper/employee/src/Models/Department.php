<?php

namespace Sniper\Employee\Models;

use Baum\Node;

class Department extends Node
{
    protected $table = 'sniper_employee_departments';
    protected $guarded = [];
}
