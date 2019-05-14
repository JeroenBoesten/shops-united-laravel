<?php

namespace JeroenOnline\ShopsUnitedLaravel;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JeroenOnline\ShopsUnitedLaravel\Skeleton\SkeletonClass
 */
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
