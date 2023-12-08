<?php

namespace TheCoderRaman\AssetsVersion\Tests\Feature;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use TheCoderRaman\AssetsVersion\AssetsVersion;
use TheCoderRaman\AssetsVersion\Tests\TestCase;
use TheCoderRaman\AssetsVersion\Tests\Concerns\GeneratorTrait;

class AssetsVersionCacheCommandTest extends TestCase
{
    use GeneratorTrait;

    /**
     * Test assets version cache command.
     *
     * @return void
     */
    public function testAssetsVersionCache(): void
    {
        $assetsVersion = $this->app->make(
            AssetsVersion::class
        );

        Artisan::call('assets-version:cache');

        $this->assertTrue(file_exists($path
            = $assetsVersion->getVersionFilePath())
        );

        $versioned = require $path;

        $versions = collect($versioned['versions'])->keys();
        $files = $this->generateFilePathWithContents()->values();

        $this->assertEquals(count($versions), $files->count() - 1);
        $this->assertEquals(1, $files->values()->diff($versions)->count());
    }
}
