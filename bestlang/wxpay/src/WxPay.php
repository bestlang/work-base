<?php
namespace BestLang\WxPay;

use Endroid\QrCode\QrCode;

use BestLang\WxPay\Pay\Gateway\NativePay;
use BestLang\WxPay\Services\NativeNotifyCallBack;
use BestLang\WxPay\Services\PayNotifyCallBack;
use BestLang\WxPay\Pay\Log\CLogFileHandler;
use BestLang\WxPay\Pay\Log\Log;
use BestLang\WxPay\Pay\Data\WxPayUnifiedOrder;
use BestLang\WxPay\Pay\Contracts\OrderInterface;

class WxPay
{
    public function native1($order_no)
    {
        $nativePay = new NativePay;
        $url = $nativePay->GetPrePayUrl($order_no);
        $qrCode = new QrCode($url);
        return $qrCode->writeDataUri();
    }

    //native1
    public function wechatNativeNotify()
    {
        $nativeNotifyCallBack = new NativeNotifyCallBack;
        $logHandler = new CLogFileHandler(storage_path()."/logs/wxpay-".date('Y-m-d').'.log');
        $log = Log::Init($logHandler, 15);
        Log::DEBUG("begin notify native1 !");
        $nativeNotifyCallBack->Handle();
    }

    //native2
    public function wechatAsyncNotify()
    {
        $payNotifyCallBack = new PayNotifyCallBack;
        $logHandler = new CLogFileHandler(storage_path()."/logs/".'wxpay-notify-'.date('Y-m-d').'.log');
        $log = Log::Init($logHandler, 15);
        Log::DEBUG("begin notify");
        $payNotifyCallBack->Handle();
    }

    public function native2(OrderInterface $order)
    {
        $config = app()['wxConfig'];
        $wxPayUnifiedOrder = new WxPayUnifiedOrder;
        $nativePay = new NativePay;
        //前台确认支付之后请求本动作
        $wxPayUnifiedOrder->SetBody($order->getName());
        //$wxPayUnifiedOrder->SetAttach('xxx');
        $wxPayUnifiedOrder->SetOut_trade_no($order->getOrderNo().'_'.time());
        $wxPayUnifiedOrder->SetTotal_fee($order->getMoney() * 100);
        $wxPayUnifiedOrder->SetTime_start(date("YmdHis"));
        $wxPayUnifiedOrder->SetTime_expire(date("YmdHis", time() + 600));
        //$wxPayUnifiedOrder->SetGoods_tag("xxx");
        $wxPayUnifiedOrder->SetNotify_url($config->GetNotifyUrl());
        $wxPayUnifiedOrder->SetTrade_type("NATIVE");
        $wxPayUnifiedOrder->SetProduct_id($order->getId());

        $result = $nativePay->GetPayUrl($wxPayUnifiedOrder);
        $url = $result["code_url"];
        $qrCode = new QrCode($url);
        return $qrCode->writeDataUri();
    }
}