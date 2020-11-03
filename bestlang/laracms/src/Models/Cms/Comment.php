<?php

namespace BestLang\LaraCms\Models\Cms;

use BestLang\LaraCms\Models\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'cms_comments';

    public function ref()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name');
    }
}
