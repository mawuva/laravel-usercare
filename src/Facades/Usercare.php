<?php

namespace Mawuekom\Usercare\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mawuekom\Usercare\Skeleton\SkeletonClass
 */
class Usercare extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'usercare';
    }
}
