<?php

namespace App\Pdd;

use Illuminate\Database\Eloquent\Model;

class ThemeGoodsSearch extends Model
{
    //
    protected $table = 'pdd_theme_goods_searches';
    protected $guarded = [];
    protected $casts = [
        'aio' => 'array'
    ];
}
