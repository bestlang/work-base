<?php

return [
    'appId' => env('WXPAY_APP_ID',''),
    'merchantId' => env('WXPAY_MERCHANT_ID', ''),
    'key' => env('WXPAY_KEY', ''),
    'appSecret' => env('WXPAY_APP_SECRET', ''),
    'notifyUrl' => env('WXPAY_NOTIFY_URL', ''),
    'sslCertPath' => env('WXPAY_SSL_CERT_PATH', ''),
    'sslKeyPath' => env('WXPAY_SSL_KEY_PATH', ''),
];