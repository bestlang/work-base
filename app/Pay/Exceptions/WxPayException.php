<?php
namespace App\Pay\Exceptions;

class WxPayException extends \Exception {
    public function errorMessage()
    {
        return $this->getMessage();
    }
}