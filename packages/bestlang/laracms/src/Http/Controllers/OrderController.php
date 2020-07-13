<?php
namespace Bestlang\Laracms\Http\Controllers;


use Illuminate\Http\Request;
use Bestlang\Laracms\Models\Cms\Order;
use Bestlang\Laracms\Models\Cms\Content;

class OrderController
{
    public function generate(Request $request)
    {
        $content_id = $request->input('content_id', 0);
        $num = $request->input('num', 0);
        $content = Content::find($content_id);
        $price = $content->getExt()['price'];
        $order = new Order;
        $order->name = $content->title;
        $order->money = $price * $num;
        $order->save();
        return response()->ajax($order);
    }
    public function detail($order_no,Request $request)
    {
        $order = Order::where('order_no', $order_no)->first();
        return view('laracms::dark.order.detail', ['order' => $order]);
    }
}