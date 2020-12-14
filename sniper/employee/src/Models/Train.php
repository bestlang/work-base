<?php

namespace Sniper\Employee\Models;

use Sniper\Employee\Models\TrainParticipant;
use Illuminate\Database\Eloquent\Model;
use Sniper\Employee\Models\User;

class Train extends Model
{
    protected $table = 'sniper_employee_trains';
    protected $guarded = [];

    public function participants()
    {
        return $this->belongsToMany(User::class, 'sniper_employee_train_participants', 'train_id', 'user_id')
            ->using(TrainParticipant::class);
    }
}
