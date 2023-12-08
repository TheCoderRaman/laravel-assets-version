<?php

namespace TheCoderRaman\AssetsVersion\Tests\Feature;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use TheCoderRaman\AssetsVersion\AssetsVersion;
use TheCoderRaman\AssetsVersion\Tests\TestCase;
use TheCoderRaman\AssetsVersion\Tests\Concerns\GeneratorTrait;

class HelpersTest extends TestCase
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
            js_path('example1.js')
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
            css_path('example1.css')
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
            asset_path('css/example1.css')
        );

        parse_str($parsedUrl['query'] ?? '', $query);

        $this->assertTrue(!empty($query['v'] ?? null));
    }
}
