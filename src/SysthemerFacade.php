<?php

namespace Mawuekom\Systhemer;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mawuekom\Systhemer\Skeleton\SkeletonClass
 */
class SysthemerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'systhemer';
    }
}
