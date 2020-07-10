<?php
namespace Bestlang\Laracms\Http\Controllers;


use Illuminate\Http\Request;
use Bestlang\Laracms\Models\Cms\Order;

class OrderController
{
    public function generate(Request $request)
    {
        $name = $request->input('name', null);
        $money = $request->input('money', null);
        $order = new Order;
        $order->name = $name;
        $order->money = $money;
        $order->save();
    }
    public function detail()
    {
        return view('laracms::dark.order.detail');
    }
}