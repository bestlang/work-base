<?php

namespace Bestlang\Laracms\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Bestlang\Laracms\Models\Cms\Model as CmsModel;

class Content extends Model
{
    protected $table = 'cms_contents';
    protected $guarded = [];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function contents()
    {
        return $this->hasMany(ContentContent::class);
    }

    public function metas()
    {
        return $this->hasMany(ContentMeta::class);
    }

    public function model()
    {
        return $this->belongsTo(CmsModel::class);
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'cms_position_contents', 'content_id', 'position_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->with('user');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'cms_content_tags','content_id','tag_id');
    }
}
