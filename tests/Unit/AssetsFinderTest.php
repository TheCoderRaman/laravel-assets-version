<?php

namespace TheCoderRaman\AssetsVersion\Tests\Unit;

use \Mockery;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use TheCoderRaman\AssetsVersion\AssetsFinder;
use TheCoderRaman\AssetsVersion\Tests\TestCase;
use TheCoderRaman\AssetsVersion\Tests\Concerns\GeneratorTrait;

class AssetsFinderTest extends TestCase
{
    use GeneratorTrait;

    /**
     * Test assets finder creation.
     *
     * @return void
     */
    public function testAssetsFinderCreation(): void
    {
        $this->assertInstanceOf(
            AssetsFinder::class,
            $this->app->make(
                AssetsFinder::class, ["options" => []]
            )
        );
    }

    /**
     * Test assets finder apply options method.
     *
     * @return void
     */
    public function testAssetsFinderApplyOptions(): void
    {
        $config = $this->app['config'];

        $options = Arr::get(
            $config,
            'assets-version.finder'
        );

        $mockMethod = Mockery::mock(
            AssetsFinder::class,
            ["options" => $options]
        );

        ($mockMethod
            ->shouldReceive('applyOptions')
            ->with($options)
            ->andReturnSelf()->once()
        );

        $mockMethod->applyOptions($options);
    }

    /**
     * Test assets finder config depth option.
     *
     * @return void
     */
    public function testConfigDepthOption(): void
    {
        $config = $this->app['config'];

        $options = [
            'depth' => '== 0',
        ];

        $finder = $this->app->make(
            AssetsFinder::class, [
                "options" => []
            ]
        );

        $finder->applyOptions($options);

        $finder->in(Arr::get(
            $config, 'assets-version.assets_path'
        ));

        $files = (collect($finder)->map(
            function ($file){
                return ($file
                    ->getRelativePathname()
                );
            }
        )->filter(
            function ($path){
                return (!empty($path) &&
                    Str::contains($path, '.')
                );
            }
        ));

        $this->assertTrue($finder->hasResults());

        $this->assertEquals($files->count(), 2);
        $this->assertEquals(
            $files->values()->toArray(),[
                "hello.ignoreme", "test.txt",
            ]
        );
    }

    /**
     * Test assets finder config size option.
     *
     * @return void
     */
    public function testConfigSizeOption(): void
    {
        $config = $this->app['config'];

        $options = [
            'size' => '<= 0k',
        ];

        $finder = $this->app->make(
            AssetsFinder::class, [
                "options" => []
            ]
        );

        $finder->applyOptions($options);

        $finder->in(Arr::get(
            $config, 'assets-version.assets_path'
        ));

        $files = (collect($finder)->map(
            function ($file){
                return ($file
                    ->getRelativePathname()
                );
            }
        )->filter(
            function ($path){
                return (!empty($path) &&
                    Str::contains($path, '.')
                );
            }
        ));

        $this->assertTrue($finder->hasResults());
        $this->assertEquals($files->count(), 1);
        $this->assertEquals(
            $files->values()->toArray(),["test.txt"]
        );
    }

    /**
     * Test assets finder config name option.
     *
     * @return void
     */
    public function testConfigNotNameOption(): void
    {
        $config = $this->app['config'];

        $options = [
            'notName' => ['*.css', '*.js'],
        ];

        $finder = $this->app->make(
            AssetsFinder::class, [
                "options" => []
            ]
        );

        $finder->applyOptions($options);

        $finder->in(Arr::get(
            $config, 'assets-version.assets_path'
        ));

        $files = (collect($finder)->map(
            function ($file){
                return ($file
                    ->getRelativePathname()
                );
            }
        )->filter(
            function ($path){
                return (!empty($path) &&
                    Str::contains($path, '.')
                );
            }
        ));

        $this->assertTrue($finder->hasResults());

        $this->assertEquals($files->count(), 2);
        $this->assertEquals(
            $files->values()->toArray(),[
                "hello.ignoreme", "test.txt",
            ]
        );
    }

    /**
     * Test assets finder config name option.
     *
     * @return void
     */
    public function testConfigNameOption(): void
    {
        $config = $this->app['config'];

        $options = [
            'name' => ['*.css', '*.js'],
        ];

        $finder = $this->app->make(
            AssetsFinder::class, [
                "options" => []
            ]
        );

        $finder->applyOptions($options);

        $finder->in(Arr::get(
            $config, 'assets-version.assets_path'
        ));

        $files = (collect($finder)->map(
            function ($file){
                return ($file
                    ->getRelativePathname()
                );
            }
        )->filter(
            function ($path){
                return (!empty($path) &&
                    Str::contains($path, '.')
                );
            }
        ));

        $this->assertTrue($finder->hasResults());
        $this->assertEquals($files->count(), 14);

        $this->assertEquals(0,
            $files->values()->diff([
                'js\example1.js',
                'js\example2.js',
                'js\example3.js',
                'js\example4.js',
                'js\example5.js',
                'css\example1.css',
                'css\example2.css',
                'css\example3.css',
                'css\example4.css',
                'css\example5.css',
                'libs\ipsum\js\lorem.js',
                'libs\lorem\js\ipsum.js',
                'libs\ipsum\css\lorem.css',
                'libs\lorem\css\ipsum.css',
            ])->count()
        );
    }

    /**
     * Test assets finder config exclude option.
     *
     * @return void
     */
    public function testConfigExcludeOption(): void
    {
        $config = $this->app['config'];

        $options = [
            'exclude' => 'libs',
        ];

        $finder = $this->app->make(
            AssetsFinder::class, [
                "options" => []
            ]
        );

        $finder->applyOptions($options);

        $finder->in(Arr::get(
            $config, 'assets-version.assets_path'
        ));

        $files = (collect($finder)->map(
            function ($file){
                return ($file
                    ->getRelativePathname()
                );
            }
        )->filter(
            function ($path){
                return (!empty($path) &&
                    Str::contains($path, '.')
                );
            }
        ));

        $this->assertTrue($finder->hasResults());
        $this->assertEquals($files->count(), 12);

        $this->assertEquals(0,
            $files->values()->diff([
                'test.txt', 'css\example1.css',
                'hello.ignoreme', 'js\example1.js',
                'js\example2.js', 'js\example3.js',
                'js\example4.js', 'js\example5.js',
                'css\example2.css', 'css\example3.css',
                'css\example4.css', 'css\example5.css',
            ])->count()
        );
    }
}
