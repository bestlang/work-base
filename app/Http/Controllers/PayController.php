<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Pay\Gateway\NativePay;
use App\Pay\Data\WxPayUnifiedOrder;
use App\Pay\Log\CLogFileHandler;
use App\Pay\Log\Log;
use App\Pay\Custom\NativeNotifyCallBack;
use App\Pay\WxPayConfig;
use App\Pay\Custom\PayNotifyCallBack;

use BestLang\LaraCms\Models\Cms\Order;
use Endroid\QrCode\QrCode;

class PayController extends Controller
{
    protected $wxPayUnifiedOrder, $nativePay, $wxPayConfig;
    public function __construct(WxPayUnifiedOrder $wxPayUnifiedOrder, NativePay $nativePay, WxPayConfig $wxPayConfig)
    {
        $this->wxPayUnifiedOrder = $wxPayUnifiedOrder;
        $this->nativePay = $nativePay;
        $this->wxPayConfig = $wxPayConfig;
    }
//    public function native2(Request $request)
//    {
//        $orderNo = $request->input('order_no');
//        $order = Order::where('order_no', $orderNo)->first();
//        $user = auth()->user();
//        if(!$user){
//            return response()->error('请先登录', 401);
//        }
//        //前台确认支付之后请求本动作
//        $this->wxPayUnifiedOrder->SetBody($order->name);
//        //$wxPayUnifiedOrder->SetAttach('xxx');
//        $this->wxPayUnifiedOrder->SetOut_trade_no($orderNo);
//        $this->wxPayUnifiedOrder->SetTotal_fee($order->money * 100);
//        $this->wxPayUnifiedOrder->SetTime_start(date("YmdHis"));
//        $this->wxPayUnifiedOrder->SetTime_expire(date("YmdHis", time() + 600));
//        //$wxPayUnifiedOrder->SetGoods_tag("xxx");
//        $this->wxPayUnifiedOrder->SetNotify_url($this->wxPayConfig->GetNotifyUrl());
//        $this->wxPayUnifiedOrder->SetTrade_type("NATIVE");
//        $this->wxPayUnifiedOrder->SetProduct_id($order->id);
//
//        $result = $this->nativePay->GetPayUrl($this->wxPayUnifiedOrder);
//        $url2 = $result["code_url"];
//        $qrCode = new QrCode($url2);
//        return response()->ajax($qrCode->writeDataUri());
//    }
}
