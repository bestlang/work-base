<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'cms_comments';

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
