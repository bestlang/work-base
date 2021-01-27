<?php

namespace BestLang\LaraCMS\Observers\CMS;

use BestLang\LaraCMS\Models\CMS\Order;

class OrderObserver
{
    public function creating(Order $order)
    {
        if(!$order->order_no){
            $order->order_no = static::findAvailableNo();
        }
        if(!$order->order_no){
            return false;
        }
    }
    public static function findAvailableNo()
    {
        $prefix = date('YmdHis');
        for ($i = 0; $i < 10; $i++) {
            $order_no = $prefix.str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            if (!Order::query()->where('order_no', $order_no)->exists()) {
                return $order_no;
            }
        }
        return false;
    }
}