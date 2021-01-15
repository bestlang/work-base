<?php

namespace Sniper\Employee\Models\Competence;

use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    protected $table = 'sniper_position_abilities';

    public function category()
    {
        return $this->belongsTo(AbilityCategory::class, 'category_id', 'id');
    }
}
