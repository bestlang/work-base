<?php

namespace Bestlang\Laracms\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'cms_orders';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
    }
}
