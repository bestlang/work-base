<?php
namespace Sniper\Employee\Facades;

use Illuminate\Support\Facades\Facade;

class SniperEmployee extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sniperEmployee';
    }
}