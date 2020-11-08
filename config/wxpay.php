<?php

return [
    'appId' => env('WXPAY_APP_ID','wx49a724deab97c52b'),
    'merchantId' => env('WXPAY_MERCHANT_ID', '1542382061'),
    'key' => env('WXPAY_KEY', 'odkj90LyLEgq7ewanhdd8t1wHbvc7b39'),
    'appSecret' => env('WXPAY_APP_SECRET', ''),
    'notifyUrl' => env('WXPAY_NOTIFY_URL', 'https://www.laracms.com/notify/wechat/async'),
    'sslCertPath' => env('WXPAY_SSL_CERT_PATH', ''),
    'sslKeyPath' => env('WXPAY_SSL_KEY_PATH', ''),
];