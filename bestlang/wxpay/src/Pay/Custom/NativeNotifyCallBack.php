<?php
namespace BestLang\WxPay\Pay\Custom;

use BestLang\WxPay\Pay\Data\WxPayUnifiedOrder;
use BestLang\WxPay\Pay\Log\Log;
use BestLang\WxPay\Pay\WxPayConfig;
use BestLang\WxPay\Pay\WxPayNotify;

use BestLang\Laracms\Models\Cms\Order;
use BestLang\WxPay\Pay\WxPayApi;

//native第一种支付方式, 需要调用统一下单Api
class NativeNotifyCallBack extends WxPayNotify
{
    public function unifiedOrder($openId, $order_no)
    {
        $config = new WxPayConfig();
        $order = Order::where('order_no', $order_no)->first();
        //统一下单
        $input = new WxPayUnifiedOrder();
        $input->SetBody($order->name);
        //$input->SetAttach("xxx");
        $input->SetOut_trade_no($order_no.'_'.time());
        $input->SetTotal_fee($order->money * 100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        //$input->SetGoods_tag("xxx");
        $input->SetNotify_url($config->GetNotifyUrl());
        $input->SetTrade_type("NATIVE");
        $input->SetOpenid($openId);
        $input->SetProduct_id($order->product_id);
        try {
            $result = WxPayApi::unifiedOrder($config, $input);
            Log::DEBUG("unifiedorder:" . json_encode($result));
        } catch(Exception $e) {
            Log::ERROR(json_encode($e));
        }
        return $result;
    }

    /**
     *
     * 回包前的回调方法
     * 业务可以继承该方法，打印日志方便定位
     * @param string $xmlData 返回的xml参数
     *
     **/
    public function LogAfterProcess($xmlData)
    {
        Log::DEBUG("call back， return xml:" . $xmlData);
        return;
    }

    /**
     * @param WxPayNotifyResults $objData 回调解释出的参数
     * @param WxPayConfigInterface $config
     * @param string $msg 如果回调处理失败，可以将错误信息输出到该方法
     * @return true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
     */
    public function NotifyProcess($objData, $config, &$msg)
    {
        $data = $objData->GetValues();
        //echo "处理回调";
        Log::DEBUG("call back:" . json_encode($data));
        //1、进行参数校验
        if(!array_key_exists("openid", $data) ||
            !array_key_exists("product_id", $data))
        {
            $msg = "回调数据异常";
            Log::DEBUG($msg  . json_encode($data));
            return false;
        }

        //2、进行签名验证
        try {
            $checkResult = $objData->CheckSign($config);
            if($checkResult == false){
                //签名错误
                Log::ERROR("签名错误...");
                return false;
            }
        } catch(Exception $e) {
            Log::ERROR(json_encode($e));
        }

        $openid = $data["openid"];
        $product_id = $data["product_id"];

        //3、处理业务逻辑
        //统一下单
        $result = $this->unifiedOrder($openid, $product_id);
        if(!array_key_exists("appid", $result) ||
            !array_key_exists("mch_id", $result) ||
            !array_key_exists("prepay_id", $result))
        {
            $msg = "统一下单失败";
            Log::DEBUG($msg  . json_encode($data));
            Log::DEBUG($msg  . json_encode($result));
            return false;
        }

        $this->SetData("appid", $result["appid"]);
        $this->SetData("mch_id", $result["mch_id"]);
        $this->SetData("nonce_str", WxPayApi::getNonceStr());
        $this->SetData("prepay_id", $result["prepay_id"]);
        $this->SetData("result_code", "SUCCESS");
        $this->SetData("err_code_des", "OK");
        return true;
    }
}