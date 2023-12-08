<?php

namespace TheCoderRaman\AssetsVersion\Tests\Feature;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use TheCoderRaman\AssetsVersion\AssetsVersion;
use TheCoderRaman\AssetsVersion\Tests\TestCase;
use TheCoderRaman\AssetsVersion\Tests\Concerns\GeneratorTrait;

class AssetsVersionTest extends TestCase
{
    use GeneratorTrait;

    /**
     * Test assets version js path creation.
     *
     * @return void
     */
    public function testjsPathCreation(): void
    {
        Artisan::call('assets-version:cache');

        $assetsVersion = $this->app->make(
            AssetsVersion::class
        );

        $assetsVersion->refreshVersionLookup();

        $this->assertTrue(file_exists($path
            = $assetsVersion->getVersionFilePath())
        );

        $parsedUrl = parse_url(
            $assetsVersion->jsPath('example1.js')
        );

        parse_str($parsedUrl['query'] ?? '', $query);

        $this->assertTrue(!empty($query['v'] ?? null));
    }

    /**
     * Test assets version css path creation.
     *
     * @return void
     */
    public function testCssPathCreation(): void
    {
        Artisan::call('assets-version:cache');

        $assetsVersion = $this->app->make(
            AssetsVersion::class
        );

        $assetsVersion->refreshVersionLookup();

        $this->assertTrue(file_exists($path
            = $assetsVersion->getVersionFilePath())
        );

        $parsedUrl = parse_url(
            $assetsVersion->cssPath('example1.css')
        );

        parse_str($parsedUrl['query'] ?? '', $query);

        $this->assertTrue(!empty($query['v'] ?? null));
    }

    /**
     * Test assets version asset path creation.
     *
     * @return void
     */
    public function testAssetPathCreation(): void
    {
        Artisan::call('assets-version:cache');

        $assetsVersion = $this->app->make(
            AssetsVersion::class
        );

        $assetsVersion->refreshVersionLookup();

        $this->assertTrue(file_exists($path
            = $assetsVersion->getVersionFilePath())
        );

        $parsedUrl = parse_url(
            $assetsVersion->assetPath('css/example1.css')
        );

        parse_str($parsedUrl['query'] ?? '', $query);

        $this->assertTrue(!empty($query['v'] ?? null));
    }
}
