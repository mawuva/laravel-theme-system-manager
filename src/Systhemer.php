<?php

namespace Mawuekom\Systhemer;

use Mawuekom\Systhemer\Traits\HandleFiles;

class Systhemer
{
    use HandleFiles;

    /**
     * Get a themes directory.
     *
     * @return string
     */
    public function getThemesDirectory(): string
    {
        return config('systhemer.themes_directory', base_path('themes'))
                ?? base_path('themes');
    }

    /**
     * Ensure themes directory exists.
     *
     * @return void
     */
    public function ensureThemesDirectoryExists()
    {
        $this ->ensureDirectoryExists($this ->getThemesDirectory());
    }

    /**
     * Check if the theme exists.
     *
     * @param string $theme
     *
     * @return bool
     */
    public function themeExists(string $theme): bool
    {
        if (str_contains($theme, '/') || str_contains($theme, '\/')) {
            if (is_filepath($theme) && is_dir($theme))
                return true;
        }

        else {
            if (theme_path($theme) !== false && is_dir(theme_path($theme)) &&
                preg_match(config('systhemer.name_regex', '/(.[a-zA-Z0-9-_]+)/'), $theme) !== false)
                    return true;
        }

        return false;
    }
}