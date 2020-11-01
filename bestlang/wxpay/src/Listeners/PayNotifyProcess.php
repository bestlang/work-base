<?php

namespace BestLang\WxPay\Listeners;

use BestLang\WxPay\Events\PayNotify;
use BestLang\WxPay\Pay\Contracts\OrderInterface;


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
        $order = app()[OrderInterface::class]->getOrderByOrderNo($order_no);
        $order->status = 1;
        $order->save();
    }
}