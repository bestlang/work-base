<?php

namespace BestLang\LaraCms\Models\Cms;

use BestLang\LaraCms\Models\User;
use Illuminate\Database\Eloquent\Model;
use BestLang\LaraCms\Models\Cms\Model as CmsModel;

class Content extends Model
{
    protected $table = 'cms_contents';
    protected $guarded = [];
    protected $ext = [];

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

    public function getExt()
    {
        $metas = $this->metas()->get();
        $ext = [];
        foreach ($metas as $meta){
            $ext[$meta->field] = json_decode($meta->value) ? json_decode($meta->value, true) : $meta->value;
        }
        return $ext;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function __get($key)
    {
        if(!count($this->ext)){
            $this->ext = $this->getExt();
        }
        return $this->getAttribute($key) ?? $this->ext[$key] ?? '';
    }
}
