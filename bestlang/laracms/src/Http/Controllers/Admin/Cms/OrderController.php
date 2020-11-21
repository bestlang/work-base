<?php
namespace BestLang\LaraCms\Http\Controllers\Admin\Cms;

use BestLang\LaraCms\Http\Controllers\Controller;
use BestLang\LaraCms\Models\Cms\Order;
use Illuminate\Http\Request;
use Arr;


class OrderController extends Controller
{
    public function orders(Request $request)
    {
        $page = $request->input('page', 0);
        $page_size = $request->input('page_size', 10);

        $query = Order::query();
        $total = $query->count();
        try{
            $orders = $query->with('user')
                ->orderBy('id', 'desc')
                ->limit($page_size)
                ->offset(($page-1)*$page_size)
                ->get();
        }catch (\Exception $e){
            return response()->error($e->getMessage());
        }

        return response()->ajax(compact(['orders', 'total']));
    }

    public function detail(Request $request)
    {
        $order_no = $request->input('order_no');
        $order = Order::with('user')->where('order_no', $order_no)->first();
        return response()->ajax($order);
    }

    public function close(Request $request)
    {
        $order_no = $request->input('order_no');
        $params = $request->all();
        $order = Order::where('order_no', $order_no)->first();
        if($order){
            $status = Arr::get($params, 'status', 0);
            if($status != $order->status && $order->status == 0){
                $order->status = $status;
            }
        }
        $order->save();
        return response()->ajax();
    }
}