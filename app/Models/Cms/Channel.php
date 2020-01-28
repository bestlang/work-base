<?php

namespace App\Models\Cms;

use Baum\Node;
use App\Models\Cms\Content;

class Channel extends Node
{
    protected $table = 'cms_channels';
    protected $guarded = [];

    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
