<?php

namespace App\Pdd;

use Illuminate\Database\Eloquent\Model;

class ThemeListGet extends Model
{
    //
    protected $table = 'pdd_theme_list_get';
    protected $fillable = ['aio','page','page_size'];
}
