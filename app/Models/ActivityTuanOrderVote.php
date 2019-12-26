<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityTuanOrderVote extends Model
{
    protected $table = 'activity_tuan_order_votes';
    protected $guarded = [];

    public function scopeEffective($query)
    {
        return $query->where('effective', 1);
    }

    public function userInfo()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
