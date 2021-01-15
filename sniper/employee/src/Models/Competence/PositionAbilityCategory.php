<?php

namespace Sniper\Employee\Models\Competence;

use Illuminate\Database\Eloquent\Model;

class PositionAbilityCategory extends Model
{
    // 职位-能力分类 关系表
    protected $table = 'sniper_position_ability_categories';
    protected $guarded = [];

    public function abilities()
    {
        return $this->hasMany(Ability::class, 'category_id', 'id');
    }
}
