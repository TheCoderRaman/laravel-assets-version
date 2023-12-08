<?php

namespace TheCoderRaman\AssetsVersion\Console;

use \Throwable;
use \LogicException;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use TheCoderRaman\AssetsVersion\AssetsFinder;
use TheCoderRaman\AssetsVersion\AssetsVersion;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'assets-version:cache')]
class AssetsVersionCacheCommand extends Command
{
    /**
     * The illuminate filesystem instance.
     *
     * @var Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'assets-version:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache assets versions';

    /**
     * Create a new asset version cache command instance.
     *
     * @param Filesystem $filesystem
     * @return void
     */
    public function __construct(
        Filesystem $filesystem
    ){
        parent::__construct();
        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('assets-version:clear');

        $assetsVersion = (
            $this->laravel->make(AssetsVersion::class)
        );

        $this->saveAssetVersionCache(
            $assetsVersion->getVersionFilePath(),
            $this->generateAssetsVersion($assetsVersion)
        );

        $this->info('Assets version cached!');
    }

    /**
     * Save asset version cache into cache file
     *
     * @param string $versionFilePath
     * @param array $versionedAssets
     * @return void
     */
    protected function saveAssetVersionCache(
        string $versionFilePath, array $versionedAssets
    ){
        $directory = substr(
            $versionFilePath, 0, strrpos($versionFilePath, '/')
        );

        try
        {

            if(!$this->filesystem->isDirectory($directory)){
                $this->filesystem->makeDirectory(
                    $directory, 0777, true
                );
            }

            $assetsVersion = ($this->laravel
                ->make(AssetsVersion::class)
            );

            $versioned = $this->generateAssetsVersion(
                $assetsVersion
            );

            ksort($versioned, SORT_NATURAL);

            $this->filesystem->put(
                $versionFilePath, $this->generateVersionFile($versioned)
            );

        } catch (Throwable $exception) {
            $this->filesystem->delete($versionFilePath);

            throw new LogicException(
                'Assets version file are not cached.', 0, $exception
            );
        }
    }

    /**
     * Generate assets version cache file contents.
     *
     * @param array $versioned
     * @return string
     */
    protected function generateVersionFile(array $versioned)
    {
        return '<?php return '.var_export($versioned, true).';'.PHP_EOL;
    }

    /**
     * Generate asset files version array.
     *
     * @param AssetsVersion $assetsVersion
     * @return array
     */
    protected function generateAssetsVersion(AssetsVersion $assetsVersion)
    {
        $versioned = [];

        $assetsFinder = $this->laravel->make(
            AssetsFinder::class,['options'
                => $assetsVersion->getNamedConfig("finder")
            ]
        );

        $assetsFinder->in($basePath =
            $assetsVersion->getNamedConfig("assets_path")
        );

        if(!$assetsFinder->hasResults()){
            return [];
        }

        foreach($assetsFinder as $assetFile)
        {
            $absolutePath = $assetFile->getRealPath();

            if($assetFile->isDir()){
                continue;
            }

            if (!is_file($absolutePath)) {
                $this->error(
                    "Versioning file [{$absolutePath}] failed."
                );

                continue;
            }

            $relativePath = ltrim(Str::after(
                $absolutePath, $assetsVersion->getAssetPath()
            ),DIRECTORY_SEPARATOR);

            $relativePath = str_replace("\\", "/", $relativePath);

            $relativePath = ltrim(str_replace(
                Str::afterLast($basePath,DIRECTORY_SEPARATOR), '', $relativePath
            ), "/");

            $versioned[$relativePath] = substr(
                $this->filesystem->hash(
                    $absolutePath, $assetsVersion->getNamedConfig("hash_algorithm")
                ), 0, 10
            );
        }

        return [
            "total" => count($versioned), "createAt" => now()->timestamp, "versions" => $versioned,
        ];
    }
}