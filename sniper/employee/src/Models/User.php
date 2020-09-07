<?php
namespace Sniper\Employee\Models;

use Bestlang\Base\Models\User as BaseUser;

class User extends BaseUser
{
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
}