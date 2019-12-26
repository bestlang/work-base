<?php

namespace App\Pdd;

use Illuminate\Database\Eloquent\Model;

class TopGoodsListQuery extends Model
{
    //
    protected $table = 'pdd_top_goods_list_queries';
    protected $fillable = ['aio','offset','limit'];
    protected $casts = [
        'aio' => 'array'
    ];
}
