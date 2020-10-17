<?php
namespace Sniper\Employee\Models;

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
}