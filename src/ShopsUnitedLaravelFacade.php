<?php

namespace JeroenBoesten\ShopsUnitedLaravel;

use Illuminate\Support\Facades\Facade;

class ShopsUnitedLaravelFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'shops-united-laravel';
    }
}
