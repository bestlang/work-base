<?php

namespace App\Models\Cms;

use Baum\Node;
use App\Models\Cms\ChannelContent;
use App\Models\Cms\ChannelMeta;

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
        return $this->hasMany(ChannelContent::class);
    }

    public function metas()
    {
        return $this->hasMany(ChannelMeta::class);
    }

    public function model()
    {
        return $this->belongsTo(Model::class);
    }
}
