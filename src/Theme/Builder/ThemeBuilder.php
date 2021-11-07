<?php

namespace Mawuekom\Systhemer\Theme\Builder;

use Mawuekom\Systhemer\Exceptions\ThemeAlreadyExists;
use Mawuekom\Systhemer\Theme\Theme;
use Mawuekom\Systhemer\Traits\HandleFiles;

class ThemeBuilder
{
    use HandleFiles;

    /**
     * Theme instance
     * 
     * @var \Mawuekom\Systhemer\Theme\Theme
     */
    private $theme;

    public function __construct(Theme $theme)
    {
        $this ->theme = $theme;
    }

    /**
     * Get theme object
     *
     * @return \Mawuekom\Systhemer\Theme\Theme
     */
    public function getTheme()
    {
        return $this ->theme;
    }

    public function execute()
    {
        if (systhemer() ->themeExists($this ->theme ->getPath())) {
            throw new ThemeAlreadyExists($this ->theme ->getName());
        }

        $this ->ensureDirectoryExists($this ->theme ->getPath());
    }
}