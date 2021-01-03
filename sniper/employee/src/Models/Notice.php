<?php

namespace Sniper\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use BestLang\Base\Events\ModelCreatedEvent;
use BestLang\Base\Events\ModelDeletedEvent;
use BestLang\Base\Events\ModelUpdatedEvent;

class Notice extends Model
{
    use SoftDeletes;

    protected $table = 'sniper_employee_notices';
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
    public function audiences()
    {
        return $this->belongsToMany(User::class, 'sniper_employee_notice_audiences', 'notice_id', 'user_id')
            ->using(NoticeAudience::class);
    }
}
