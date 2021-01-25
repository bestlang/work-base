<?php

namespace BestLang\LaraCMS\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'cms_positions';
    protected $guarded = [];

    public function subs()
    {
        return $this->hasMany(static::class, 'parent_id', 'id');
    }

    public function channels()
    {
        return $this->belongsToMany(Channel::class, 'cms_position_channels', 'position_id', 'channel_id')->withPivot(['order_factor']);
    }

    public function contents()
    {
        return $this->belongsToMany(Content::class, 'cms_position_contents', 'position_id', 'content_id')->withPivot(['order_factor'])->with('channel');
    }
}
