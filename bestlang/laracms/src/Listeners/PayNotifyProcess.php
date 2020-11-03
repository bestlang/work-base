<?php

namespace BestLang\LaraCms\Listeners;

use BestLang\LaraCms\Events\PayNotify;
use BestLang\LaraCms\Models\Cms\Order;

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