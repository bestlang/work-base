<?php
namespace Bestlang\Laracms\Http\Controllers;


use Illuminate\Http\Request;
use Bestlang\Laracms\Models\Cms\Order;
use Bestlang\Laracms\Services\OrderGenerator;

use App\Pay\Data\WxPayUnifiedOrder;
use App\Pay\Gateway\NativePay;
use App\Pay\WxPayConfig;
use Endroid\QrCode\QrCode;

use App\Pay\Log\CLogFileHandler;
use App\Pay\Custom\NativeNotifyCallBack;
use App\Pay\Log\Log;

use App\Pay\Custom\PayNotifyCallBack;

class OrderController
{
    protected $wxPayUnifiedOrder, $nativePay, $wxPayConfig;

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
        return view('laracms::dark.order.detail', ['order' => $order]);
    }
    //native1
    public function native1(Request $request, NativePay $nativePay)
    {
        $order_no = $request->input('order_no');
        $url1 = $nativePay->GetPrePayUrl($order_no);
        $qrCode = new QrCode($url1);
//        echo $url1;
//        echo "<img src=\"".$qrCode->writeDataUri()."\" />";
        return response()->ajax($qrCode->writeDataUri());
    }
    //native1 需要调用统一下单api的
    public function wechatNativeNotify(WxPayConfig $config, NativeNotifyCallBack $nativeNotifyCallBack)
    {
        //初始化日志
        $logHandler = new CLogFileHandler(storage_path()."/logs/".date('Y-m-d').'.log');
        $log = Log::Init($logHandler, 15);
        Log::DEBUG("begin notify!");
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
        $this->wxPayUnifiedOrder = $wxPayUnifiedOrder;
        $this->nativePay = $nativePay;
        $this->wxPayConfig = $wxPayConfig;

        $orderNo = $request->input('order_no');
        $order = Order::where('order_no', $orderNo)->first();
        $user = auth()->user();
        if(!$user){
            return response()->error('请先登录', 401);
        }
        //前台确认支付之后请求本动作
        $this->wxPayUnifiedOrder->SetBody($order->name);
        //$wxPayUnifiedOrder->SetAttach('xxx');
        $this->wxPayUnifiedOrder->SetOut_trade_no($orderNo);
        $this->wxPayUnifiedOrder->SetTotal_fee($order->money * 100);
        $this->wxPayUnifiedOrder->SetTime_start(date("YmdHis"));
        $this->wxPayUnifiedOrder->SetTime_expire(date("YmdHis", time() + 600));
        //$wxPayUnifiedOrder->SetGoods_tag("xxx");
        $this->wxPayUnifiedOrder->SetNotify_url($this->wxPayConfig->GetNotifyUrl());
        $this->wxPayUnifiedOrder->SetTrade_type("NATIVE");
        $this->wxPayUnifiedOrder->SetProduct_id($order->id);

        $result = $this->nativePay->GetPayUrl($this->wxPayUnifiedOrder);
        $url2 = $result["code_url"];
        $qrCode = new QrCode($url2);
        return response()->ajax($qrCode->writeDataUri());
    }

}