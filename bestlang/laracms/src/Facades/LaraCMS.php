<?php

namespace BestLang\LaraCMS\Facades;

use Illuminate\Support\Facades\Facade;

class LaraCMS extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laracms';
    }
}
