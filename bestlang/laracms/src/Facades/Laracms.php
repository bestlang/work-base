<?php

namespace BestLang\Laracms\Facades;

use Illuminate\Support\Facades\Facade;

class Laracms extends Facade
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
