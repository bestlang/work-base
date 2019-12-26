<?php

namespace App\Pdd;

use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    protected $table = 'pdd_cats';
    protected $guarded = [];
    public $timestamps = false;
}
