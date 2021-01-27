<?php
namespace BestLang\LaraCMS\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class AdPosition extends Model
{
    protected $table = 'cms_ad_positions';
    protected $guarded = [];

    public function ads()
    {
        return $this->hasMany(Ad::class, 'position_id', 'id');
    }
}