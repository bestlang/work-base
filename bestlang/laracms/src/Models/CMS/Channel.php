<?php

namespace BestLang\LaraCMS\Models\CMS;

use Baum\Node;
use BestLang\LaraCMS\Models\CMS\Content;
use BestLang\LaraCMS\Models\CMS\ChannelMeta;

class Channel extends Node
{
    protected $table = 'cms_channels';
    protected $guarded = [];
    protected $ext = [];

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
    public function getExt()
    {
        $metas = $this->metas()->get();
        $ext = [];
        foreach ($metas as $meta){
            $ext[$meta->field] = json_decode($meta->value) ? json_decode($meta->value, true) : $meta->value;
        }
        return $ext;
    }

    public function __get($key)
    {
        if(!count($this->ext)){
            $this->ext = $this->getExt();
        }
        return $this->getAttribute($key) ?? $this->ext[$key] ?? '';
    }

}
