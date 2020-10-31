<?php
namespace BestLang\WxPay\Pay\Gateway;

use BestLang\WxPay\Pay\Data\WxPayBizPayUrl;
use BestLang\WxPay\Pay\WxPayApi;
use BestLang\WxPay\Pay\Log\Log;
use \Exception;
/**
 *
 * 刷卡支付实现类
 * @author widyhu
 *
 */
class NativePay
{
    /**
     *
     * 生成扫描支付URL,模式一
     * @param BizPayUrlInput $bizUrlInfo
     */
    /**
     * @param $productId
     * @return string
     */
    public function GetPrePayUrl($productId)
    {
        $biz = new WxPayBizPayUrl();
        $biz->SetProduct_id($productId);
        try{
            $values = WxpayApi::bizpayurl($biz);
        } catch(Exception $e) {
            Log::ERROR(json_encode($e));
        }
        $url = "weixin://wxpay/bizpayurl?" . $this->ToUrlParams($values);
        return $url;
    }

    /**
     *
     * 参数数组转换为url参数
     * @param array $urlObj
     */
    /**
     * @param $urlObj
     * @return string
     */
    private function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v)
        {
            $buff .= $k . "=" . $v . "&";
        }

        $buff = trim($buff, "&");
        return $buff;
    }

    /**
     *
     * 生成直接支付url，支付url有效期为2小时,模式二
     * @param UnifiedOrderInput $input
     */
    /**
     * @param $input
     * @return bool
     */
    public function GetPayUrl($input)
    {
        if($input->GetTrade_type() == "NATIVE")
        {
            try{
                $result = WxPayApi::unifiedOrder($input);
                return $result;
            } catch(Exception $e) {
                Log::ERROR(json_encode($e));
            }
        }
        return false;
    }
}