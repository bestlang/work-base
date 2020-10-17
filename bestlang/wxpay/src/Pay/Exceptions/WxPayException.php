<?php
namespace Bestlang\WxPay\Pay\Exceptions;

class WxPayException extends \Exception {
    public function errorMessage()
    {
        return $this->getMessage();
    }
}