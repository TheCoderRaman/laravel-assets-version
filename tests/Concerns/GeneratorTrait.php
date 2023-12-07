<?php

namespace TheCoderRaman\AssetsVersion\Tests\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;

trait GeneratorTrait
{
    /**
     * Dot for escaping dot (.) while creating directory.
     *
     * @var string
     */
    protected string $dot = '||\^_^/||';

    /**
     * Temporary assets file paths.
     *
     * @var array<int|string,array<mixed>>
     */
    protected $files = [
        'js' => [
            'example1.js',
            'example2.js',
            'example3.js',
            'example4.js',
            'example5.js',
        ],
        'css' => [
            'example1.css',
            'example2.css',
            'example3.css',
            'example4.css',
            'example5.css',
        ],
        'libs' => [
            'lorem' => [
                'js.' => 'ipsum.js',
                'css.' => 'ipsum.css',
            ],
            'ipsum' => [
                'js.' => 'lorem.js',
                'css.' => 'lorem.css',
            ]
        ],
        'test.*.txt' => '#',
        '.*.gitignore' => '#*.ignoreme',
        'hello.*.ignoreme' => '#Just Ignore This',
    ];

    /**
     * Setup test workspace.
     *
     * @return void
     */
    protected function setupTestWorkspace(): void
    {
        $config = $this->app['config']['assets-version'];

        $this->createTempAssetsDirectory($config['assets_path']);
    }

    /**
     * Tear down test workspace.
     *
     * @return void
     */
    protected function tearDownTestWorkspace(): void
    {
        $config = $this->app['config']['assets-version'];

        $this->deleteTempAssetsDirectory($config['assets_path']);
    }

    /**
     * Create temparary assets directory.
     *
     * @param string $assetsDir
     * @return void
     */
    protected function deleteTempAssetsDirectory(string $assetsDir): void
    {
        $assetsDirectory = (
            realpath($assetsDir)
        );

        $filesystem = ($this->app
            ->make(Filesystem::class)
        );

        if(!$filesystem->isDirectory($assetsDir)){
            return;
        }

        $filesystem->deleteDirectory(realpath($assetsDir));
    }

    /**
     * Generate files path with contents from given files.
     *
     * @return Collection
     */
    protected function generateFilePathWithContents(): Collection
    {
        $config = $this->app['config']['assets-version'];

        $assetsDir = realpath($config['assets_path']);

        return (collect(Arr::dot($this->files))->flip()
            ->map(fn($path) => str_replace('.*.', $this->dot, $path))
            ->map(fn($path) => str_replace('.', '/', $path))
            ->map(fn($path) => preg_replace('/[0-9]+/', '', $path))
            ->map(fn($path) => str_replace($this->dot, '.', $path))
            ->map(function ($path, $file){
                [$file] = explode('#', $file);

                $file = rtrim($file, '/');

                return Str::replaceLast('/','', "{$path}/{$file}");
            })->flip()->map(function ($content){
                if(!Str::contains($content, "#")){
                    return uniqid();
                }

                return Str::after($content, '#');
            })->flip()
        );
    }

    /**
     * Create temparary assets directory.
     *
     * @param string $assetsDir
     * @return void
     */
    protected function createTempAssetsDirectory(string $assetsDir): void
    {
        $this->deleteTempAssetsDirectory($assetsDir);

        $filesystem = $this->app->make(Filesystem::class);

        $filesystem->makeDirectory(
            $assetsDir, 0777, true
        );

        $assetsDir = realpath($assetsDir);

        (collect(Arr::dot($this->files))->flip()
            ->map(fn($path) => str_replace('.*.', $this->dot, $path))
            ->map(fn($path) => str_replace('.', '/', $path))
            ->map(fn($path) => preg_replace('/[0-9]+/', '', $path))
            ->map(fn($path) => str_replace($this->dot, '.', $path))
            ->map(function ($path, $file){
                [$file] = explode('#', $file);

                $file = rtrim($file, '/');

                return Str::replaceLast('/','', "{$path}/{$file}");
            })->flip()->map(function ($content){
                if(!Str::contains($content, "#")){
                    return uniqid();
                }

                return Str::after($content, '#');
            })->flip()->map(fn($path) =>
                realpath($assetsDir)."/{$path}"
            )->map(function ($path) use($filesystem) {
                (!$filesystem->isDirectory(
                    substr($path, 0, strrpos( $path, '/'))
                ) && $filesystem->makeDirectory(
                    substr($path, 0, strrpos( $path, '/')), 0777, true
                ));

                return $path;
            })->map(fn($path, $contents) => file_put_contents($path, $contents))
        );
    }
};