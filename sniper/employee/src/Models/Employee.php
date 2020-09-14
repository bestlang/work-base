<?php

namespace Sniper\Employee\Models;

use Baum\Node;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'sniper_employee_employee';

    protected $primaryKey = 'user_id';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function education()
    {
        return $this->hasMany(Education::class, 'user_id', 'user_id');
    }

    public function job()
    {
        return $this->hasMany(Job::class, 'user_id', 'user_id');
    }

}
