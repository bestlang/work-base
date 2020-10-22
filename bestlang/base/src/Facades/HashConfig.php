<?php

namespace BestLang\Base\Facades;

use Illuminate\Support\Facades\Facade;

class HashConfig extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'HashConfig';
    }
}
