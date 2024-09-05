<?php

namespace TheCoderRaman\AssetsVersion;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use TheCoderRaman\AssetsVersion\Contracts\AssetsVersionInterface;

class AssetsVersion implements AssetsVersionInterface
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected Application $app;

    /**
     * The config instance.
     *
     * @var Repository
     */
    protected Repository $config;

    /**
     * All versioned files
     *
     * @var array
     */
    protected array $versioned = [];

    /**
     * Construct hashids manager instance
     *
     * @param Application $app
     * @param Repository $config
     * @return void
     */
    public function __construct(
        Application $app, Repository $config
    ) {
        $this->app = $app;
        $this->config = $config;

        $this->refreshVersionLookup();
    }

    /**
     * Get config name
     *
     * @return string
     */
    public function getConfigName(): string
    {
        return 'assets-version';
    }

    /**
     * Get the asset path.
     *
     * @return string
     */
    public function getAssetPath()
    {
        $assetPath = parse_url(
            asset('/'), PHP_URL_PATH
        );

        return (
            $this->app->basePath($assetPath)
        );
    }

    /**
     * Get the asset url.
     *
     * @return string
     */
    public function getAssetUrl()
    {
        return trim($this
            ->getNamedConfig("assets_url", '/'), "/"
        );
    }

    /**
     * Get the asset css path.
     *
     * @param string $path
     * @param bool $fullUrl
     * @return string
     */
    public function cssPath(
        string $path, bool $fullUrl = false
    ): string {
        return $this->assetPath(
            "css/" . ltrim($path, "/"), $fullUrl
        );
    }

    /**
     * Get the asset js path.
     *
     * @param string $path
     * @param bool $fullUrl
     * @return string
     */
    public function jsPath(
        string $path, bool $fullUrl = false
    ): string {
        return $this->assetPath(
            "js/" . ltrim($path, "/"), $fullUrl
        );
    }

    /**
     * Get the asset path.
     *
     * @param string $path
     * @param bool $fullUrl
     * @return string
     */
    public function assetPath(
        string $path, bool $fullUrl = false
    ): string {
        $path = ltrim($path, "/");
        $assetUrl = $this->getAssetUrl();

        if (empty($path)) {
            return asset($assetUrl);
        }

        if (!isset(
            $this->versioned[$path]
        )) {
            return asset("{$assetUrl}/{$path}");
        }

        $pathVersion = $this->versioned[$path];

        if(!$fullUrl){
            return asset("{$assetUrl}/{$path}?v={$pathVersion}");
        }

        return url(asset("{$assetUrl}/{$path}?v={$pathVersion}"));
    }

    /**
     * Refresh version lookup array.
     *
     * @return void
     */
    public function refreshVersionLookup(): void
    {
        $versionFilePath = (
            $this->getVersionFilePath()
        );

        if (!file_exists($versionFilePath)) {
            $this->versioned = [];
            return;
        };

        $versioned = require $versionFilePath;

        $this->versioned = array_merge(
            $versioned['versions'],
            $this->getNamedConfig("versioned", [])
        );
    }

    /**
     * Get assets versioning file path.
     *
     * @return string
     */
    public function getVersionFilePath(): string
    {
        return $this->app->storagePath(
            "cache/assets-version/versioned.php"
        );
    }

    /**
     * Get the given named configuration.
     *
     * @param string $name
     * @param mixed $default
     * @return string|null
     */
    public function getNamedConfig(
        string $name, $default = null
    ) {
        return $this->config->get(
            $this->getConfigName() . '.' . $name, $default
        );
    }
}
