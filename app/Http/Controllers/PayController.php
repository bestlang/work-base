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

use Bestlang\Laracms\Models\Cms\Content;

use Endroid\QrCode\QrCode;

class PayController extends Controller
{
    public function native2(Request $request, WxPayUnifiedOrder $wxPayUnifiedOrder, NativePay $nativePay, WxPayConfig $wxPayConfig)
    {
        $user = auth()->user();
        if(!$user){
            return response()->error('请先登录', 401);
        }
        //前台确认支付之后请求本动作
        $content_id = $request->input('content_id', 0);
        $num = $request->input('num', 0);
        if(!$content_id){
            return response()->error('参数错误');
        }
        if(!$num){
            return response()->error('参数错误');
        }

        $content = Content::with(['metas'])->find($content_id);
        $exts = $content->getExt();
        $price = $exts['price'];
        $wxPayUnifiedOrder->SetBody($content->title);
        $wxPayUnifiedOrder->SetAttach($user->id.'_'.$content->id);
        $wxPayUnifiedOrder->SetOut_trade_no($user->id.'_'.$content_id.'_'.date("YmdHis"));
        $wxPayUnifiedOrder->SetTotal_fee($price);
        $wxPayUnifiedOrder->SetTime_start(date("YmdHis"));
        $wxPayUnifiedOrder->SetTime_expire(date("YmdHis", time() + 600));
        //$wxPayUnifiedOrder->SetGoods_tag("m100d99");
        $wxPayUnifiedOrder->SetNotify_url($wxPayConfig->GetNotifyUrl());
        $wxPayUnifiedOrder->SetTrade_type("NATIVE");
        $wxPayUnifiedOrder->SetProduct_id($content->id);

        $result = $nativePay->GetPayUrl($wxPayUnifiedOrder);
        $url2 = $result["code_url"];
        $qrCode = new QrCode($url2);
//        echo "<img src=\"".$qrCode->writeDataUri()."\" />";
        return response()->ajax($qrCode->writeDataUri());
    }
}
