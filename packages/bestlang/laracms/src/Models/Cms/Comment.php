<?php

namespace Bestlang\Laracms\Models\Cms;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'cms_comments';

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name');
    }
}
