<?php

namespace Mawuekom\LaravelUsercare;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mawuekom\LaravelUsercare\Skeleton\SkeletonClass
 */
class LaravelUsercareFacade extends Facade
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
