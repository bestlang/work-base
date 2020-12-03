<?php

namespace Sniper\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use Sniper\Employee\Models\User;

class Wastage extends Model
{
    protected $table = 'sniper_employee_wastage';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
