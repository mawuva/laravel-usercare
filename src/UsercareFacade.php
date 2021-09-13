<?php

namespace Mawuekom\Usercare;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mawuekom\Usercare\Skeleton\SkeletonClass
 */
class UsercareFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-usercare';
    }
}
