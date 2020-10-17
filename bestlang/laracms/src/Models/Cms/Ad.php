<?php
namespace BestLang\Laracms\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $table = 'cms_ads';
    protected $guarded = [];
//    public $timestamps = ['start_time', 'end_time'];

    public function position()
    {
        return $this->belongsTo(AdPosition::class, 'position_id', 'id');
    }

}