<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alipay\EasySDK\Kernel\Factory;
use Alipay\EasySDK\Kernel\Config;

class Index2Controller extends Controller
{

    public function invoke(Request $request)
    {
        //1. 设置参数（全局只需设置一次）
        Factory::setOptions(self::getOptions());

        try {
            //2. 发起API调用
            $result = Factory::payment()->page()->pay("iPhone6 16G", "20200326235526001", "0.01", "https://www.laracms.com");
            echo $result->body;
            //3. 处理响应或异常
//            if (!empty($result['code']) && $result['code'] == 10000) {
//                echo "调用成功". PHP_EOL;
//            } else {
//                echo "调用失败，原因：". $result['msg']."，".$result['sub_msg'].PHP_EOL;
//            }
        } catch (Exception $e) {
            echo "调用失败，". $e->getMessage(). PHP_EOL;;
        }
    }

    function getOptions(){
        $options = new Config();
        $options->protocol = 'https';
        $options->gatewayHost = 'openapi.alipay.com';
        $options->signType = 'RSA2';

        $options->appId = '2021001165602449';

        // 为避免私钥随源码泄露，推荐从文件中读取私钥字符串而不是写入源码中
        $options->merchantPrivateKey = 'MIIEowIBAAKCAQEAjHMI/NGfStDWy9E49j9EVyDwQwZx9aTIJD3KNTVjEBdOsz0f3zNoQpaIVThcenrVG1mV8HxCwtkFU4qLtPcL1B5SwrOMhQIJ1Vq6G75BdbnLo2PlF9aW7KsWQVspWrxhHaKUAJu0zBQfM08rjH4ryDZLLY097A0bJCc+JMoVDdFHzlQaDfQzHT0Ixr+ORc/yERFIImKdPO88P0tunFSUNeRADRSc3KKJsQW6kFddqWO/d/UWmZOA5Qt9xtMESq8Lb/mFFco8g8I2jbZlj3aDokeAP/eW/tnpb9FjtpUA89xA2XaD2/PyYETIXMhqsJadQkgYq26xXnNKIhq0wKTMZwIDAQABAoIBAHrjFBQRXazaeXYwBAUBakxJ167tbrydhziej9Rqd9jWa9fMPZzPoAPTLkpSXCgWXWvmwJiAQPG3bT+hU4ftOH5KYeNVsjeWhwAUuA4aM7BL9m9pskNfUQKW14wrtU1c0iRZ4eF+W3zMhlggh1wP8ULmrnSWxn1JIlxJscgCwNUq4idsY5RsXhF8QgjK+EKDd606yjyyEUncnL07ya7ZSDjUKcg7FfI3vlIqaN3Dq5xedh/Gq9Asr2omzpYpyYJzu0fNkwunV7U3ObSWGfmB1PJvPBMKSWdhLRYuJrt0mtIJJ9AbU581sugFfo3U2A1HHXPkQeYjKvQekdYrqda/XhECgYEAwQ5BC6IZ6ZdnMXsNbK/uvN+/QjA6mfKYZeJ/ph1DRpT52Sji/lmumC01rtP67MZbadsCh20Tp/OMZB8798dcpniTuG9o2Gh4CfXQ1S7rcIknfMS32cFNKs1CaTuH5t7n1JPGYQ8vWxUlt9rxrrU5+tI9mhW2cmBJ0OSzSo1D3h0CgYEAuj3l2Ey6EdDvSBJb5ng6ZcWHYnXbIFYboJNZYdsjTtnxU/glYHxWhlnRHyMxUTdGt+RpJUYEE7x+X6lkWiYHAAcHP2hJiTHXBfDo3XrSYzdAEy+lgjaMBPPsASAhnoVnvXmKuaISs0lnu+1IYbOPOzKKRtJ8JBEFnYqYrOpcnVMCgYEAqsPjAVlHtnn4C6qe+067zFHWKcPjch1GdIjfBJ7JzXslbdNexkGp0G3dGGHliN8EKSRSnlv7kQo7WqzOLKQp7g6mC/RwN0xhMd4/9PJly8tmJFUVkwYLLhsV7WN9GNh/FGgKh/wYlWalUHXYZgNj39tsJgmispU9dgt2FDHUoHkCgYBdeYWr206kdIY0WSqQ8RT2UX7S1y5E+5LgNDRvXepJwC9Uor43wBA5XEkOZL5y8dhnoZd4YrzXHwsafk1kxaNLyztDAtetqTsvuytVRjjkHS3ms0pRoYkDT13LbtIQ2wonWiJba1IRdC1BcCWdC98+qe4m/6vY+kYkPRTF7NbRCwKBgAlwUaKNByf2oB3n/TGWBANIlBiOjKxyBONiYPY9Mek2EsIKaAH41js6ArVcP+s0s0zsX8jRMt26wUNf8aX3xIbj3qU5doy7IDqxA+DAIhntnma6QOjQOQFkv0B7BaOFn63vVgeNJ02XURnon0cScXQ294dNbXGSroMitZgNSttD';

        // 请填写您的支付宝公钥证书文件路径，例如：/foo/alipayCertPublicKey_RSA2.crt;
        $options->alipayCertPath = '/usr/share/nginx/html/laracms/alipayCerts/alipayCertPublicKey_RSA2.crt';
        if(env('APP_ENV') === 'local'){
            $options->alipayCertPath = '/usr/local/var/laracms/alipayCertPublicKey_RSA2.crt';
        }

        // 请填写您的支付宝根证书文件路径，例如：/foo/alipayRootCert.crt;
        $options->alipayRootCertPath = '/usr/share/nginx/html/laracms/alipayCerts/alipayRootCert.crt';
        if(env('APP_ENV') === 'local'){
            $options->alipayRootCertPath = '/usr/local/var/laracms/alipayRootCert.crt';
        }

        // 请填写您的应用公钥证书文件路径，例如：/foo/appCertPublicKey_2019051064521003.crt;
        $options->merchantCertPath = '/usr/share/nginx/html/laracms/alipayCerts/appCertPublicKey_2021001165602449.crt';
        if(env('APP_ENV') === 'local') {
            $options->merchantCertPath = '/usr/local/var/laracms/appCertPublicKey_2021001165602449.crt';
        }

        //注：如果采用非证书模式，则无需赋值上面的三个证书路径，改为赋值如下的支付宝公钥字符串即可
        // $options->alipayPublicKey = '<-- 请填写您的支付宝公钥，例如：MIIBIjANBg... -->';

        //可设置异步通知接收服务地址（可选）
        //$options->notifyUrl = "<-- 请填写您的支付类接口异步通知接收服务地址，例如：https://www.test.com/callback -->";

        //可设置AES密钥，调用AES加解密相关接口时需要（可选）
        //$options->encryptKey = "<-- 请填写您的AES密钥，例如：aa4BtZ4tspm2wnXLb1ThQA== -->";



        return $options;
    }

    public function notify(Request $request)
    {
        info('***** alipay notify *****', [$request->all()]);
    }
}
