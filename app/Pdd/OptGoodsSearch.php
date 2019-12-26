<?php

namespace App\Pdd;

use Illuminate\Database\Eloquent\Model;

class OptGoodsSearch extends Model
{
    //
    protected $table = 'pdd_opt_goods_searches';
    protected $fillable = ['opt_id', 'page', 'page_size', 'aio'];
}
