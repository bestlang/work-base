<?php

namespace BestLang\Laracms\Models\Cms;

use Baum\Node;
use BestLang\Laracms\Models\Cms\Content;
use BestLang\Laracms\Models\Cms\ChannelMeta;

class Channel extends Node
{
    protected $table = 'cms_channels';
    protected $guarded = [];

    public function articles()
    {
        return $this->hasMany(Content::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function metas()
    {
        return $this->hasMany(ChannelMeta::class);
    }

    public function model()
    {
        return $this->belongsTo(Model::class);
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'cms_position_channels', 'channel_id', 'position_id');
    }

}
