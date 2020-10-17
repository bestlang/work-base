<?php

namespace Bestlang\WxPay\Facades;

use Illuminate\Support\Facades\Facade;

class WxPay extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'wxpay';
    }
}
