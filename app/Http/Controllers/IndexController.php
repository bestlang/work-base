<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Pay\Products\NativePay;
use App\Pay\Data\WxPayUnifiedOrder;
use App\Pay\Log\CLogFileHandler;
use App\Pay\Log\Log;
use App\Pay\NativeNotifyCallBack;
use App\Pay\WxPayConfig;

use Endroid\QrCode\QrCode;

class IndexController extends Controller
{
    public function native1(Request $request, NativePay $nativePay)
    {
        echo $nativePay->GetPrePayUrl(time());
    }

    public function native2(Request $request, WxPayUnifiedOrder $wxPayUnifiedOrder, NativePay $nativePay)
    {
        $wxPayUnifiedOrder->SetBody("一件神器的商品");
        $wxPayUnifiedOrder->SetAttach("感谢付款");
        $wxPayUnifiedOrder->SetOut_trade_no("sdkphp123456789".date("YmdHis"));
        $wxPayUnifiedOrder->SetTotal_fee("100");
        $wxPayUnifiedOrder->SetTime_start(date("YmdHis"));
        $wxPayUnifiedOrder->SetTime_expire(date("YmdHis", time() + 600));
        $wxPayUnifiedOrder->SetGoods_tag("m100d99");
        $wxPayUnifiedOrder->SetNotify_url("http://paysdk.weixin.qq.com/notify.php");
        $wxPayUnifiedOrder->SetTrade_type("NATIVE");
        $wxPayUnifiedOrder->SetProduct_id("123456789");

        $result = $nativePay->GetPayUrl($wxPayUnifiedOrder);
        $url2 = $result["code_url"];
        $qrCode = new QrCode($url2);

        header('Content-Type: '.$qrCode->getContentType());
        echo "<img src=\"".$qrCode->writeDataUri()."\" />";
    }

    public function notify(Request $request)
    {
        //初始化日志
        $logHandler = new CLogFileHandler(storage_path()."/logs/".date('Y-m-d').'.log');
        $log = Log::Init($logHandler, 15);
        $config = new WxPayConfig();
        Log::DEBUG("begin notify!");
        $notify = new NativeNotifyCallBack();
        $notify->Handle($config, true);
    }
}
