<?php

namespace Mawuekom\LaravelThemeSystemManager;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mawuekom\LaravelThemeSystemManager\Skeleton\SkeletonClass
 */
class LaravelThemeSystemManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-theme-system-manager';
    }
}
