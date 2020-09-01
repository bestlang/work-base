<?php

namespace Bestlang\Laracms\Models;

use Bestlang\Base\Models\User as BaseUser;
use Bestlang\Laracms\Models\Cms\Comment;
use Bestlang\Laracms\Models\Cms\Order;

class User extends BaseUser
{

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
}
