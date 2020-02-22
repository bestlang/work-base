<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class PositionContent extends Model
{
    protected $table = 'cms_position_contents';
    protected $guarded = [];

    public function content()
    {
        return $this->hasOne(Content::class, 'content_id', 'content_id');
    }
}
