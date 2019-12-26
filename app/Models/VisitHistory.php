<?php

namespace App\Models;

use App\Pdd\GoodsPromotionUrlGenerate;
use Illuminate\Database\Eloquent\Model;

class VisitHistory extends Model
{
    protected $table = 'visit_histories';
    protected $guarded = [];
    public $timestamps = false;

    public function goods()
    {
        return $this->hasOne(GoodsPromotionUrlGenerate::class, 'goods_id', 'goods_id');
    }
}
