<?php
namespace Sniper\Employee\Models;

use Bestlang\Base\Models\User as BaseUser;
use Sniper\Employee\Models\Employee;

class User extends BaseUser
{
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }
}