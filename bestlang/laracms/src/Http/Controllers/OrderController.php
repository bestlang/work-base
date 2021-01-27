<?php
namespace BestLang\LaraCMS\Http\Controllers;


use Illuminate\Http\Request;
use BestLang\LaraCMS\Models\CMS\Order;

use BestLang\LaraCMS\Services\OrderGenerator;
use HashConfig;


class OrderController
{
    protected $wxPayUnifiedOrder, $nativePay, $wxPayConfig;
    public $theme;
    public function __construct()
    {
        $this->theme = HashConfig::get('site', 'theme');
    }
    public function orders(Request $request)
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(6);
        return view("LaraCMS::themes.{$this->theme}.order.orders", ['orders' => $orders]);
    }

    public function detail($order_no, Request $request)
    {
        $order = Order::where('order_no', $order_no)->firstOrFail();
        return view("LaraCMS::themes.{$this->theme}.order.orderDetail", ['order' => $order]);
    }

    public function generate(Request $request)
    {
        $content_id = $request->input('content_id');
        $num = $request->input('num');
        $orderGenerator = new OrderGenerator;
        $order = $orderGenerator($content_id, $num);
        return response()->ajax($order);
    }

    public function orderPay($order_no, Request $request)
    {
        $order = Order::where('order_no', $order_no)->firstOrFail();
        return view("LaraCMS::themes.{$this->theme}.order.pay", ['order' => $order]);
    }
}