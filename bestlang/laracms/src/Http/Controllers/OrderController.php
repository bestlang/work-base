<?php
namespace BestLang\LaraCms\Http\Controllers;


use Illuminate\Http\Request;
use BestLang\LaraCms\Models\Cms\Order;

use BestLang\LaraCms\Services\OrderGenerator;



class OrderController
{
    protected $wxPayUnifiedOrder, $nativePay, $wxPayConfig;

    public function orders(Request $request)
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)->paginate(5);
        return render('ucenter.orders', ['orders' => $orders]);
    }

    public function generate(Request $request)
    {
        $content_id = $request->input('content_id');
        $num = $request->input('num');
        $orderGenerator = new OrderGenerator;
        $order = $orderGenerator($content_id, $num);
        return response()->ajax($order);
    }

    public function detail($order_no,Request $request)
    {
        $order = Order::where('order_no', $order_no)->first();
        return render('order.detail', ['order' => $order]);
    }
}