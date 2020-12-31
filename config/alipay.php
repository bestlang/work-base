<?php

return [
    'appId' => env('ALIPAY_APP_ID'),
    'merchantPrivateKey' => env('ALIPAY_MERCHANT_PRIVATE_KEY'),
    'alipayCertPath' => env('ALIPAY_CERT_PATH'),
    'alipayRootCertPath' => env('ALIPAY_ROOT_CERT_PATH'),
    'merchantCertPath' => env('ALIPAY_MERCHANT_CERT_PATH'),
    'returnUrl' => env('ALIPAY_RETURN_URL'),
    'asyncNotifyUrl' => env('ALIPAY_ASYNC_NOTIFY_URL')
    ];
