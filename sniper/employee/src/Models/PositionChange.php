<?php

namespace Sniper\Employee\Models;

use Illuminate\Database\Eloquent\Model;

class PositionChange extends Model
{
    protected $table = 'sniper_employee_position_changes';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
