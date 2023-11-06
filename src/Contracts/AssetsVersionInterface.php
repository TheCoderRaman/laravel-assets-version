<?php

namespace TheCoderRaman\AssetsVersion\Contracts;

interface AssetsVersionInterface
{
    /**
     * Get the asset css path.
     *
     * @param string $path
     * @return string
     */
    public function cssPath(string $path): string;

    /**
     * Get the asset js path.
     *
     * @param string $path
     * @return string
     */
    public function jsPath(string $path): string;

    /**
     * Get the asset path.
     *
     * @param string $path
     * @return string
     */
    public function assetPath(string $path): string;
}
