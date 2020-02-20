<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'cms_positions';
    protected $guarded = [];

    public function subs()
    {
        return $this->hasMany(static::class, 'parent_id', 'id');
    }
}
