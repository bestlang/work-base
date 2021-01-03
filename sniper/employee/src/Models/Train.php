<?php

namespace Sniper\Employee\Models;

use Sniper\Employee\Models\TrainParticipant;
use Illuminate\Database\Eloquent\Model;
use Sniper\Employee\Models\User;
use BestLang\Base\Events\ModelCreatedEvent;
use BestLang\Base\Events\ModelDeletedEvent;
use BestLang\Base\Events\ModelUpdatedEvent;

class Train extends Model
{
    protected $table = 'sniper_employee_trains';
    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => ModelCreatedEvent::class,
        'deleted' => ModelDeletedEvent::class,
        'updated' => ModelUpdatedEvent::class
    ];

    public function participants()
    {
        return $this->belongsToMany(User::class, 'sniper_employee_train_participants', 'train_id', 'user_id')
            ->using(TrainParticipant::class);
    }
}
