<?php
namespace BestLang\Laracms\Http\Controllers;


use Illuminate\Http\Request;
use BestLang\Laracms\Models\Cms\Order;

use BestLang\WxPay\Pay\Data\WxPayUnifiedOrder;
use BestLang\WxPay\Pay\Gateway\NativePay;
use BestLang\WxPay\Pay\WxPayConfig;
use Endroid\QrCode\QrCode;
use BestLang\WxPay\Pay\Log\CLogFileHandler;
use BestLang\WxPay\Pay\Log\Log;

use BestLang\Laracms\Services\WxPay\NativeNotifyCallBack;
use BestLang\Laracms\Services\OrderGenerator;
use BestLang\Laracms\Services\WxPay\PayNotifyCallBack;



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