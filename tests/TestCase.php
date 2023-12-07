<?php

namespace TheCoderRaman\AssetsVersion\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Mockery\Adapter\Phpunit\MockeryTestCaseSetUp;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use TheCoderRaman\AssetsVersion\AssetsVersionServiceProvider;
use TheCoderRaman\AssetsVersion\Support\Facades\AssetsVersion;

class TestCase extends OrchestraTestCase

{
    use WithWorkbench;
    use MockeryTestCaseSetUp;
    use MockeryPHPUnitIntegration;

    /**
     * Automatically enables package discoveries.
     *
     * @var bool
     */
    protected $enablesPackageDiscoveries = true;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->handleCallbacks();

        parent::setUp(...func_get_args());

        $config = $this->app->make(
            Repository::class
        );

        $config->set(
            "assets-version", $this->getConfig()
        );

        $this->setupTestWorkspace();
    }

    /**
     * Setup test workspace.
     *
     * @return void
     */
    protected function setupTestWorkspace(): void
    {
        //
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown(): void
    {
        $this->tearDownTestWorkspace();
        parent::tearDown(...func_get_args());
    }

    /**
     * Tear down test workspace.
     *
     * @return void
     */
    protected function tearDownTestWorkspace(): void
    {
        //
    }

        /**
     * Handle testbench callbacks.
     *
     * @return void
     */
    protected function handleCallbacks(): void
    {
        $this->afterApplicationCreated(
            function () {
                // Code after application created.
            }
        );

        $this->beforeApplicationDestroyed(
            function () {
                // Code before application destroyed.
            }
        );
    }

    /**
     * Override application aliases.
     *
     * @param  Application  $app
     * @return array<string, class-string<Facade>>
     */
    protected function getPackageAliases($app)
    {
        return [
            'AssetsVersion' => AssetsVersion::class,
        ];
    }

    /**
     * Get package providers.
     *
     * @param  mixed $app
     * @return array<int, class-string<ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            AssetsVersionServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        tap($app['config'], function (Repository $config) {
            $config->set(
                "app.asset_url", 'assets'
            );

            $config->set(
                "assets-version", $this->getConfig()
            );
        });
    }

    /**
     * Get config from configuration file.
     *
     * @return array
     */
    protected function getConfig()
    {
        return include __DIR__ . '/../config/assets-version.php';
    }
}
