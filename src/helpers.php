<?php

use Mawuekom\Systhemer\Systhemer;

if (! function_exists('systhemer')) {
    /**
     * Get systhemer instance.
     *
     * @return \Mawuekom\Systhemer\Systhemer
     */
    function systhemer(): Systhemer {
        return app(Systhemer::class);
    }
}

if (! function_exists('resolve_theme_path')) {
    /**
     * Resolve / Build the path to the theme folder.
     *
     * @param  string  $path
     *
     * @return string
     */
    function resolve_theme_path(string $path) {
        return systhemer() ->getThemesDirectory() . DIRECTORY_SEPARATOR . $path;
    }
}

if (! function_exists('theme_path')) {
    /**
     * Get the path to the theme folder.
     *
     * @param  string  $path
     *
     * @return string|false
     */
    function theme_path(string $path) {
        return realpath(resolve_theme_path($path));
    }
}

if (! function_exists('is_filepath')) {
    /**
     * Check if the given path is a valid or not.
     *
     * @param  string  $path
     *
     * @return bool
     */
    function is_filepath($path) {
        $path = trim($path);
        $path_regex = '/^[^*?"<>|:]*$/';

        if (preg_match($path_regex,$path)) 
            return true;

        if ( ! defined('WINDOWS_SERVER')) {
            $tmp = dirname(__FILE__);

            (strpos($tmp, '/', 0) !== false)
                ? define('WINDOWS_SERVER', false)
                : define('WINDOWS_SERVER', true);
        }

        if (WINDOWS_SERVER) {
            if (strpos($path, ":") == 1 && preg_match('/[a-zA-Z]/', $path[0])) {
                $tmp = substr($path, 2);
                $bool = preg_match($path_regex, $tmp);

                return ($bool == 1);
            }

            return false;
        }

        return false;
    }
}