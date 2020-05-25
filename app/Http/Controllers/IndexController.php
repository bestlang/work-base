<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Pay\Gateway\NativePay;
use App\Pay\Data\WxPayUnifiedOrder;
use App\Pay\Log\CLogFileHandler;
use App\Pay\Log\Log;
use App\Pay\NativeNotifyCallBack;
use App\Pay\WxPayConfig;
use App\Pay\PayNotifyCallBack;

use Endroid\QrCode\QrCode;

class IndexController extends Controller
{
    public function native1(Request $request, NativePay $nativePay)
    {
        $url1 = $nativePay->GetPrePayUrl(time());
        $qrCode = new QrCode($url1);
        echo "<img src=\"".$qrCode->writeDataUri()."\" />";
    }

    public function native2(Request $request, WxPayUnifiedOrder $wxPayUnifiedOrder, NativePay $nativePay)
    {
        $wxPayUnifiedOrder->SetBody("一件神器的商品");
        $wxPayUnifiedOrder->SetAttach("感谢付款");
        $wxPayUnifiedOrder->SetOut_trade_no("sdkphp123456789".date("YmdHis"));
        $wxPayUnifiedOrder->SetTotal_fee("1");
        $wxPayUnifiedOrder->SetTime_start(date("YmdHis"));
        $wxPayUnifiedOrder->SetTime_expire(date("YmdHis", time() + 600));
        $wxPayUnifiedOrder->SetGoods_tag("m100d99");
        $wxPayUnifiedOrder->SetNotify_url("https://www.laracms.com/notify/wechat/native");
        $wxPayUnifiedOrder->SetTrade_type("NATIVE");
        $wxPayUnifiedOrder->SetProduct_id("123456789");

        $result = $nativePay->GetPayUrl($wxPayUnifiedOrder);
        $url2 = $result["code_url"];
        $qrCode = new QrCode($url2);
        echo "<img src=\"".$qrCode->writeDataUri()."\" />";
    }

    public function wechatNativeNotify(Request $request, WxPayConfig $config)
    {
        //初始化日志
        $logHandler = new CLogFileHandler(storage_path()."/logs/".date('Y-m-d').'.log');
        $log = Log::Init($logHandler, 15);
//        $config = new WxPayConfig();
        Log::DEBUG("begin notify!");
        $notify = new NativeNotifyCallBack();
        $notify->Handle($config, true);
    }

    public function notify(Request $request, PayNotifyCallBack $payNotifyCallBack, WxPayConfig $config)
    {
        $logHandler = new CLogFileHandler(storage_path()."/logs/".'notify-'.date('Y-m-d').'.log');
        $log = Log::Init($logHandler, 15);
        Log::DEBUG("begin notify");
        $payNotifyCallBack->Handle($config, false);
    }
}
