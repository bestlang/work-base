<?php
namespace BestLang\WxPay\Pay\Exceptions;

class WxPayException extends \Exception {
    public function errorMessage()
    {
        return $this->getMessage();
    }
}