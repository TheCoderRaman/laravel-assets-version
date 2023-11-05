<?php

use TheCoderRaman\AssetsVersion\Contracts\AssetsVersionInterface;

if (!function_exists('css_path')) {
    /**
     * Get the path to the versioned CSS asset file.
     *
     * @param  string  $path
     * @param bool $fullUrl
     * @return string
     */
    function css_path(string $path, bool $fullUrl = false): string
    {
        if (empty($path)) {
            return asset('/');
        }

        return app(AssetsVersionInterface::class)->cssPath($path);
    }
}

if (!function_exists('js_path')) {
    /**
     * Get the path to the versioned JS asset file.
     *
     * @param  string  $path
     * @param bool $fullUrl
     * @return string
     */
    function js_path(string $path, bool $fullUrl = false)
    {
        if (empty($path)) {
            return asset('/');
        }

        return app(AssetsVersionInterface::class)->jsPath($path);
    }
}

if (!function_exists('asset_path')) {
    /**
     * Get the path to the versioned asset file.
     *
     * @param  string  $path
     * @param bool $fullUrl
     * @return string
     */
    function asset_path(string $path, bool $fullUrl = false)
    {
        if (empty($path)) {
            return asset('/');
        }

        return app(AssetsVersionInterface::class)->assetPath($path);
    }
}
