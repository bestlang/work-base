<?php

namespace Bestlang\Laracms\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'cms_tags';
    protected $guarded = [];

    public function contents()
    {
        return $this->belongsToMany(Content::class, 'cms_content_tags', 'tag_id', 'content_id');
    }
}