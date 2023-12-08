<?php

namespace TheCoderRaman\AssetsVersion\Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use TheCoderRaman\AssetsVersion\AssetsVersion;
use TheCoderRaman\AssetsVersion\Tests\TestCase;
use TheCoderRaman\AssetsVersion\Tests\Concerns\GeneratorTrait;

class AssetsVersionClearCommandTest extends TestCase
{
    use GeneratorTrait;

    /**
     * Test assets version clear command.
     *
     * @return void
     */
    public function testAssetsVersionClear(): void
    {
        $assetsVersion = $this->app->make(
            AssetsVersion::class
        );

        Artisan::call('assets-version:cache');

        $this->assertTrue(file_exists($path
            = $assetsVersion->getVersionFilePath())
        );

        Artisan::call('assets-version:clear');

        $this->assertFalse(file_exists($path
            = $assetsVersion->getVersionFilePath())
        );
    }
}
