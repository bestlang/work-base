<?php

namespace Bestlang\Laracms\Facades;

use Illuminate\Support\Facades\Facade;

class LC extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'lc';
    }
}
