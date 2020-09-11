<?php

namespace Sniper\Employee\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'sniper_employee_education';
    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'user_id', 'user_id');
    }
}
