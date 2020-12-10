<?php

namespace Sniper\Employee\Models;

use App\Sniper\Employee\Models\TrainParticipant;
use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    protected $table = 'sniper_employee_trains';
    protected $guarded = [];

    public function participants()
    {
        return $this->hasMany(TrainParticipant::class);
    }
}
