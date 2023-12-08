<?php

namespace TheCoderRaman\AssetsVersion;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository;
use TheCoderRaman\AssetsVersion\AssetsFinder;
use TheCoderRaman\AssetsVersion\AssetsVersion;
use Illuminate\Contracts\Support\DeferrableProvider;
use TheCoderRaman\AssetsVersion\Contracts\AssetsFinderInterface;
use TheCoderRaman\AssetsVersion\Contracts\AssetsVersionInterface;
use TheCoderRaman\AssetsVersion\Console\AssetsVersionCacheCommand;
use TheCoderRaman\AssetsVersion\Console\AssetsVersionClearCommand;

class AssetsVersionServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Assets version config file path.
     *
     * @var string
     */
    protected string $configPath = (
        __DIR__ . '/../config/assets-version.php'
    );

    /**
     * Boot up the service provider
     *
     * @return void
     */
    public function boot(): void
    {
        $this->setupConfig();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerCommands();
        $this->registerAssetsVersion();
    }

    /**
     * Register asset version commands
     *
     * @return void
     */
    protected function registerCommands(): void
    {
        if (!$this->app->runningInConsole()){
            return;
        }

        $this->commands([
            AssetsVersionCacheCommand::class,
        ]);

        $this->commands([
            AssetsVersionClearCommand::class,
        ]);
    }

    /**
     * Register assets version handler
     *
     * @return void
     */
    protected function registerAssetsVersion(): void
    {
        $this->app->alias(
            'AssetsVersion',
            AssetsVersion::class
        );

        $this->app->alias(
            'AssetsVersion',
            AssetsVersionInterface::class
        );

        $this->app->singleton('AssetsVersion',
            function (Application $app) {
                return new AssetsVersion(
                    $app, $app->make(Repository::class)
                );
            }
        );
    }

    /**
     * Set up configuration for the hashids service
     *
     * @return void
     */
    protected function setupConfig(): void
    {
        $configSource = (
            realpath($this->configPath) ?: $this->configPath
        );

        if ($this->app->runningInConsole()) {
            $this->publishes([$configSource
                => config_path('assets-version.php'),
            ], 'assets-version');
        }

        $this->mergeConfigFrom($configSource, 'assets-version');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return ['AssetsVersion',
            AssetsFinder::class, AssetsFinderInterface::class,
            AssetsVersion::class, AssetsVersionInterface::class,
            AssetsVersionCacheCommand::class, AssetsVersionClearCommand::class,
        ];
    }
}
