<?php

namespace BestLang\LaraCMS\Models;

use BestLang\Base\Models\User as BaseUser;

use BestLang\LaraCMS\Models\Cms\Comment;
use BestLang\LaraCMS\Models\Cms\Content;
use BestLang\LaraCMS\Models\Cms\Order;

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
    //喜欢的文章
    public function likes()
    {
        return $this->belongsToMany(Content::class, 'cms_content_likes', 'user_id', 'content_id')->withPivot(['created_at', 'updated_at']);
    }
}
