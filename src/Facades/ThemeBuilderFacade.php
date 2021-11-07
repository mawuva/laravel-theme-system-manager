<?php

namespace Mawuekom\Systhemer\Facades;

use Illuminate\Support\Facades\Facade;

class ThemeBuilderFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'systhemer.theme-builder';
    }
}
