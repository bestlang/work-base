<?php
namespace Sniper\Employee\Models;

use App\Sniper\Employee\Models\TrainParticipant;
use BestLang\Base\Models\User as BaseUser;
use Sniper\Employee\Models\Employee;

class User extends BaseUser
{
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }

    public function dingUser()
    {
        return $this->hasOne(\Sniper\Employee\Models\DingTalk\User::class, 'orgEmail', 'email');
    }

    public function trains()
    {
        return $this->belongsToMany(Train::class, 'sniper_employee_train_participants', 'user_id', 'train_id')
            ->using(TrainParticipant::class);
    }
}