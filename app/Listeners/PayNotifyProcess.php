<?php

namespace App\Listeners;

use Bestlang\Laracms\Events\PayNotify;
use Bestlang\Laracms\Models\Cms\Order;
use App\Pay\Log\Log;

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
        list($order_no, ) = explode('_', $event->order_no);
        $order = Order::where('order_no', $order_no)->first();
        $order->status = 1;
        $order->save();
    }
}