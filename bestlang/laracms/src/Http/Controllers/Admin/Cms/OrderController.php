<?php
namespace BestLang\LaraCms\Http\Controllers\Admin\Cms;

use BestLang\LaraCms\Http\Controllers\Controller;
use BestLang\LaraCms\Models\Cms\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orders(Request $request)
    {
        $page = $request->input('page', 0);
        $page_size = $request->input('page_size', 10);

        $query = Order::query();
        $total = $query->count();
        $orders = $query->with('user')
            ->orderBy('id', 'desc')
            ->limit($page_size)
            ->offset(($page-1)*$page_size)
            ->get();
        return response()->ajax(compact(['orders', 'total']));
    }

    public function detail(Request $request)
    {
        $order_no = $request->input('order_no');
        $order = Order::with('user')->where('order_no', $order_no)->first();
        return response()->ajax($order);
    }
}