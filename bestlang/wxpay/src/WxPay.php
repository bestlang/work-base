<?php
namespace BestLang\WxPay;

use Endroid\QrCode\QrCode;
use BestLang\WxPay\Pay\Gateway\NativePay;

class WxPay
{
    // Build wonderful things
    public function native1($order_no, NativePay $nativePay)
    {
        $url = $nativePay->GetPrePayUrl($order_no);
        $qrCode = new QrCode($url);
        return $qrCode->writeDataUri();
    }
}