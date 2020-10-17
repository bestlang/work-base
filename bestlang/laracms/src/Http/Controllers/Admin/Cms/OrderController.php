<?php
namespace BestLang\Laracms\Http\Controllers\Admin\Cms;

use BestLang\Laracms\Http\Controllers\Controller;
use BestLang\Laracms\Models\Cms\Order;
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
}