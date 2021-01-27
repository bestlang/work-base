<?php
namespace BestLang\LaraCMS\Http\Controllers;

use Illuminate\Http\Request;
use Alipay\EasySDK\Kernel\Factory;
use Alipay\EasySDK\Kernel\Config;
use BestLang\LaraCMS\Models\CMS\Order;
use Alipay\EasySDK\Events\PayNotify;


class AliPayController
{
    public function page(Request $request)
    {
        //1. 设置参数（全局只需设置一次）
        Factory::setOptions(self::getOptions());
        $order_no = $request->input('order_no');
        $order = Order::where('order_no', $order_no)->firstOrFail();

        $result = null;
        try {
            //2. 发起API调用
            $result = Factory::payment()->page()->pay(
                $order->getName(),
                $order->getOrderNo(),
                floatval($order->getMoney()),
                config('alipay.returnUrl')
            );
            //3. 处理响应或异常
            return response()->ajax($result);
        } catch (Exception $e) {
            return response()->error("调用失败，". $e->getMessage(). PHP_EOL);
        }
    }

    function getOptions(){
        $options = new Config();
        $options->protocol = 'https';
        $options->gatewayHost = 'openapi.alipay.com';
        $options->signType = 'RSA2';

        $options->appId = config('alipay.appId');

        // 为避免私钥随源码泄露，推荐从文件中读取私钥字符串而不是写入源码中
        $options->merchantPrivateKey = config('alipay.merchantPrivateKey');

        // 请填写您的支付宝公钥证书文件路径，例如：/foo/alipayCertPublicKey_RSA2.crt;
        $options->alipayCertPath = config('alipay.alipayCertPath');

        // 请填写您的支付宝根证书文件路径，例如：/foo/alipayRootCert.crt;
        $options->alipayRootCertPath = config('alipay.alipayRootCertPath');

        // 请填写您的应用公钥证书文件路径，例如：/foo/appCertPublicKey_2019051064521003.crt;
        $options->merchantCertPath = config('alipay.merchantCertPath');

        //注：如果采用非证书模式，则无需赋值上面的三个证书路径，改为赋值如下的支付宝公钥字符串即可
        // $options->alipayPublicKey = '<-- 请填写您的支付宝公钥，例如：MIIBIjANBg... -->';

        //可设置异步通知接收服务地址（可选）
        $options->notifyUrl = config('alipay.asyncNotifyUrl');

        //可设置AES密钥，调用AES加解密相关接口时需要（可选）
        //$options->encryptKey = "<-- 请填写您的AES密钥，例如：aa4BtZ4tspm2wnXLb1ThQA== -->";



        return $options;
    }

    public function returnUrl(Request $request)
    {
        Factory::setOptions(self::getOptions());
        //验证签名
        $verifyRes = Factory::payment()->common()->verifyNotify($request->all());
        if(!$verifyRes){
            return;
        }
        $orderNo = $request->input('out_trade_no');
        event(new PayNotify($orderNo));
        return response()->redirectTo(route('orderDetail', $orderNo));
        //echo '支付成功!';
        //print_r($request->all());
        //info('***** alipay return *****', [$request->all()]);
    }

    public function asyncNotify(Request $request)
    {
        Factory::setOptions(self::getOptions());
        //验证签名
        $verifyRes = Factory::payment()->common()->verifyNotify($request->all());
        if($verifyRes){
            event(new PayNotify($request->input('out_trade_no')));
            info('***** alipay notify *****', [$request->all()]);
        }

    }

}