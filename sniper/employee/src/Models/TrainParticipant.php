<?php

namespace Sniper\Employee\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TrainParticipant extends Pivot
{
    protected $table = 'sniper_employee_train_participants';
    protected $guarded = [];
    public $incrementing = true;
}
