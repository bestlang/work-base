<?php

namespace Sniper\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use BestLang\Base\Events\ModelCreatedEvent;
use BestLang\Base\Events\ModelDeletedEvent;
use BestLang\Base\Events\ModelUpdatedEvent;

class PositionChange extends Model
{
    protected $table = 'sniper_employee_position_changes';
    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => ModelCreatedEvent::class,
        'deleted' => ModelDeletedEvent::class,
        'updated' => ModelUpdatedEvent::class
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
