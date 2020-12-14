<?php

namespace App\Sniper\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use Sniper\Employee\Models\Train;

class TrainParticipant extends Model
{
    protected $table = 'sniper_employee_train_participants';
    protected $guarded = [];
    public $incrementing = true;

    public function train()
    {
        return $this->belongsTo(Train::class);
    }
}
