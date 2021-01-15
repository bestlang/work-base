<?php

namespace Sniper\Employee\Models\Competence;

use Illuminate\Database\Eloquent\Model;
use Sniper\Employee\Models\Position;

class AbilityCategory extends Model
{
    protected $table = 'sniper_position_ability_categories';

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    public function abilities()
    {
        return $this->hasMany(Ability::class, 'category_id', 'id');
    }
}
