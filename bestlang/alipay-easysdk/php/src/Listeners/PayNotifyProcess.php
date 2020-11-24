<?php

namespace Alipay\EasySDK\Listeners;

use Alipay\EasySDK\Events\PayNotify;
use Alipay\EasySDK\Contracts\OrderInterface;


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