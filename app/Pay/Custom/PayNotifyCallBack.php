<?php
namespace App\Pay\Custom;
use App\Pay\Log\Log;
use App\Pay\Data\WxPayOrderQuery;
use App\Pay\WxPayNotify;
use Bestlang\Laracms\Events\PayNotify;
use App\Pay\WxPayConfig;
use App\Pay\WxPayApi;

// 处理支付成功回调
class PayNotifyCallBack extends WxPayNotify
{
    //查询订单
    public function Queryorder($transaction_id)
    {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);

        $config = new WxPayConfig();
        $result = WxPayApi::orderQuery($config, $input);
        Log::DEBUG("query:" . json_encode($result));
        if(array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS")
        {
            return true;
        }
        return false;
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

    //重写回调处理函数
    /**
     * @param WxPayNotifyResults $data 回调解释出的参数
     * @param WxPayConfigInterface $config
     * @param string $msg 如果回调处理失败，可以将错误信息输出到该方法
     * @return true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
     */
    public function NotifyProcess($objData, $config, &$msg)
    {
        $data = $objData->GetValues();
        //1、进行参数校验
        if(!array_key_exists("return_code", $data)
            ||(array_key_exists("return_code", $data) && $data['return_code'] != "SUCCESS")) {
            //TODO失败,不是支付成功的通知
            //如果有需要可以做失败时候的一些清理处理，并且做一些监控
            $msg = "异常异常";
            return false;
        }
        if(!array_key_exists("transaction_id", $data)){
            $msg = "输入参数不正确";
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

        //3、处理业务逻辑
        Log::DEBUG("call back:>>>>>>>:" . json_encode($data));
        /*
        {
            appid: "xxx",
            attach: [],
            bank_type: "OTHERS",
            cash_fee: "1",
            cash_fee_type: "CNY",
            fee_type: "CNY",
            is_subscribe: "Y",
            mch_id: "xxx",
            nonce_str: "xxx",
            openid: "xxx",
            out_trade_no: "xxx",
            result_code: "SUCCESS",
            return_code: "SUCCESS",
            return_msg: "OK",
            sign: "xxx",
            time_end: "xxx",
            total_fee: "1",
            trade_state: "SUCCESS",
            trade_state_desc: "支付成功",
            trade_type: "NATIVE",
            transaction_id: "xxx"
        }
        */
        event(new PayNotify($data['out_trade_no']));
        $notfiyOutput = array();


        //查询订单，判断订单真实性
        if(!$this->Queryorder($data["transaction_id"])){
            $msg = "订单查询失败";
            return false;
        }
        return true;
    }
}