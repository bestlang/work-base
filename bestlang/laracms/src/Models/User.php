<?php

namespace BestLang\LaraCms\Models;

use BestLang\Base\Models\User as BaseUser;

use BestLang\LaraCms\Models\Cms\Comment;
use BestLang\LaraCms\Models\Cms\Order;

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
