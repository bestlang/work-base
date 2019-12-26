<?php

namespace App\Models;

use App\Pdd\GoodsPromotionUrlGenerate;
use Illuminate\Database\Eloquent\Model;

class CollectGoods extends Model
{
    //
    protected $table = 'collect_goods';
    protected $guarded = [];
    public $timestamps = false;

    public function goods()
    {
        return $this->hasOne(GoodsPromotionUrlGenerate::class, 'goods_id', 'goods_id');
    }
}
