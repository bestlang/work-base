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



class WxPayController
{
    //native1
    public function native1(Request $request, NativePay $nativePay)
    {
        $order_no = $request->input('order_no');
        $url = $nativePay->GetPrePayUrl($order_no);
        $qrCode = new QrCode($url);
        return response()->ajax($qrCode->writeDataUri());
    }
    //native1 需要调用统一下单api的
    public function wechatNativeNotify(WxPayConfig $config, NativeNotifyCallBack $nativeNotifyCallBack)
    {
        //初始化日志
        $logHandler = new CLogFileHandler(storage_path()."/logs/".date('Y-m-d').'.log');
        $log = Log::Init($logHandler, 15);
        Log::DEBUG("begin notify native1 !");
        $nativeNotifyCallBack->Handle($config, true);
    }

    public function wechatAsyncNotify(Request $request, PayNotifyCallBack $payNotifyCallBack, WxPayConfig $config)
    {
        $logHandler = new CLogFileHandler(storage_path()."/logs/".'notify-'.date('Y-m-d').'.log');
        $log = Log::Init($logHandler, 15);
        Log::DEBUG("begin notify");
        $payNotifyCallBack->Handle($config, false);
    }

    //微信支付的native2
    public function native2(Request $request, WxPayUnifiedOrder $wxPayUnifiedOrder, NativePay $nativePay, WxPayConfig $wxPayConfig)
    {
        $order_no = $request->input('order_no');
        $order = Order::where('order_no', $order_no)->first();
        $user = auth()->user();
        if(!$user){
            return response()->error('请先登录', 401);
        }
        //前台确认支付之后请求本动作
        $wxPayUnifiedOrder->SetBody($order->name);
        //$wxPayUnifiedOrder->SetAttach('xxx');
        $wxPayUnifiedOrder->SetOut_trade_no($order_no.'_'.time());
        $wxPayUnifiedOrder->SetTotal_fee($order->money * 100);
        $wxPayUnifiedOrder->SetTime_start(date("YmdHis"));
        $wxPayUnifiedOrder->SetTime_expire(date("YmdHis", time() + 600));
        //$wxPayUnifiedOrder->SetGoods_tag("xxx");
        $wxPayUnifiedOrder->SetNotify_url($wxPayConfig->GetNotifyUrl());
        $wxPayUnifiedOrder->SetTrade_type("NATIVE");
        $wxPayUnifiedOrder->SetProduct_id($order->id);

        $result = $nativePay->GetPayUrl($wxPayUnifiedOrder);
        $url = $result["code_url"];
        $qrCode = new QrCode($url);
        return response()->ajax($qrCode->writeDataUri());
    }

}