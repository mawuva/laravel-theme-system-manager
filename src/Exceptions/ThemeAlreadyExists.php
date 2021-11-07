<?php

namespace Mawuekom\Systhemer\Exceptions;

use Exception;

class ThemeAlreadyExists extends Exception
{
    /**
     * Create exception instance
     *
     * @param string|null $theme
     * 
     * @return void
     */
    public function __construct(string $theme = null)
    {
        if ($theme !== null)
            $message = sprintf('The theme %s already exists', $theme);

        parent::__construct($message ?? 'Theme already exists');
    }
}
