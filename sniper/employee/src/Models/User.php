<?php
namespace Sniper\Employee\Models;

use BestLang\Base\Models\User as BaseUser;
use Sniper\Employee\Models\Employee;
use Sniper\Employee\Models\DingTalk\User as DingUser;
use BestLang\Base\Events\ModelCreatedEvent;
use BestLang\Base\Events\ModelDeletedEvent;
use BestLang\Base\Events\ModelUpdatedEvent;

class User extends BaseUser
{
    protected $dispatchesEvents = [
        'created' => ModelCreatedEvent::class,
        'deleted' => ModelDeletedEvent::class,
        'updated' => ModelUpdatedEvent::class
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }

    public function dingUser()
    {
        return $this->hasOne(DingUser::class, 'orgEmail', 'email');
    }

    public function trains()
    {
        return $this->belongsToMany(Train::class, 'sniper_employee_train_participants', 'user_id', 'train_id')
            ->using(TrainParticipant::class);
    }

    public function notices()
    {
        return $this->belongsToMany(Notice::class, 'sniper_employee_notice_audiences', 'user_id', 'notice_id')->with('user')
            ->using(NoticeAudience::class)->wherePivot('sent', 1);
    }
}