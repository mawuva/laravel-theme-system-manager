<?php

namespace Mawuekom\Systhemer\Facades;

use Illuminate\Support\Facades\Facade;

class StubManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'systhemer.stub-manager';
    }
}
