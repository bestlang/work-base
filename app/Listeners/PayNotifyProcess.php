<?php

namespace App\Listeners;

use Bestlang\Laracms\Events\PayNotify;
use Bestlang\Laracms\Models\Cms\Order;

class PayNotifyProcess
{

    /**
     * PayNotifyProcess constructor.
     */
    public function __construct()
    {
        //
    }

    public function handle(PayNotify $event)
    {
        $order_no = $event->order_no;
        $order = Order::where('order_no', $order_no)->first();
        $order->status = 1;
        $order->save();
    }
}