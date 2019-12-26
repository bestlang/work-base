<?php

namespace App\Pdd;

use Illuminate\Database\Eloquent\Model;

class GoodsPromotionUrlGenerate extends Model
{
    //
    protected $table = 'pdd_goods_promotion_url_generates';
    protected $guarded = [];
    protected $casts = [
        'aio' => 'array'
    ];
}
