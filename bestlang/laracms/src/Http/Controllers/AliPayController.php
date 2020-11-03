<?php
namespace BestLang\LaraCms\Http\Controllers;

use Illuminate\Http\Request;
use Alipay\EasySDK\Kernel\Factory;
use Alipay\EasySDK\Kernel\Config;
use BestLang\LaraCms\Models\Cms\Order;

class AliPayController
{
    public function page(Request $request)
    {
        //1. 设置参数（全局只需设置一次）
        Factory::setOptions(self::getOptions());
        $order_no = $request->input('order_no');
        $order = Order::where('order_no', $order_no)->first();

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
        echo '支付成功!';
        /*
         * {"charset":"UTF-8","out_trade_no":"20201101224821508781","method":"alipay.trade.page.pay.return","total_amount":"0.01","sign":"a/k030g2dlMCSDF+EzKQyUbl+4PJzzvkm0LkOvbajBY7bWih6mC60T/sDh5+jIuzVSLfvhXLkigr3DQlKNf3L+lGDw0aLN1C4WZH3Fz8a0tCRlt3pkWkZcL5ZGDP9+NFQk+ia5gOAAg8JJxBywQCa5mbhcYh8d2crhZD4vfxErDnISr8xfb1osDm+rxOEQarDxkOhc4ss+Bvm9r8G8ggdibYcOGYqVzOy55wgQ16TfC/4z4raJoSarv16tQ35wvr7olJmQwU5d0GIEASlYG2llm3KzQl9SKAFZzXNPhKi0UITVEEDyZuTgDq7sa4pxWHPYFNw4gq4WvxfWh63EweAA==","trade_no":"2020110122001495931413754480","auth_app_id":"2021001165602449","version":"1.0","app_id":"2021001165602449","sign_type":"RSA2","seller_id":"2088831621177204","timestamp":"2020-11-01 22:49:18"}
        */
        print_r($request->all());
        info('***** alipay return *****', [$request->all()]);
    }

    public function asyncNotify(Request $request)
    {
        //https://www.xxx.com/notify/alipay?charset=UTF-8&out_trade_no=20201017223143239893&method=alipay.trade.page.pay.return&total_amount=0.01&sign=K9tSpJRli2YKAAiy4HiX0vTZow%2BI2An6BA8Q26%2BPp%2FUh%2FOlDd9qRzLYiQJKKtZf79CLyu3MRFIN0apehsQbfrIHUHwDZnmMTpWq5lR3pXaT5dgclfmeRJQY%2BosvG48rtS8za%2FirSklkWEOReqnxtzAkU8ERdxKMOCJM%2BswaYPKlMGpdTOwc5pol3wzMI22T%2B6pZsLDohCZV2YSTcuiDlAX9oPwliDC9D0xO7yormuY35aME1UDg%2F%2BBicSeOETZu9v5x7Ntmb5TcZKc7rl7bBPUTQ1jg6c8MuXx4s7rCZi6wih%2F3dDt1uT6uJtLaZqVutv01XcgT6HJz32TAPc3pIDA%3D%3D&trade_no=2020101722001495931407744519&auth_app_id=2021001165602449&version=1.0&app_id=2021001165602449&sign_type=RSA2&seller_id=2088831621177204&timestamp=2020-10-17+22%3A32%3A23
        info('***** alipay notify *****', [$request->all()]);
    }

}