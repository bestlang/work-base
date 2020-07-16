<?php
namespace Bestlang\Laracms\Http\Controllers;


use Illuminate\Http\Request;
use Bestlang\Laracms\Models\Cms\Order;
use Bestlang\Laracms\Models\Cms\Content;
use Bestlang\Laracms\Services\OrderGenerator;

class OrderController
{
    public function generate(Request $request)
    {
        $content_id = $request->input('content_id');
        $num = $request->input('num');
        $order = new OrderGenerator($content_id, $num);
        return response()->ajax($order);
    }
    public function detail($order_no,Request $request)
    {
        $order = Order::where('order_no', $order_no)->first();
        return view('laracms::dark.order.detail', ['order' => $order]);
    }
}