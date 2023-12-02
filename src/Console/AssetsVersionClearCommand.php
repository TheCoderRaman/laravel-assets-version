<?php

namespace TheCoderRaman\AssetsVersion\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use TheCoderRaman\AssetsVersion\AssetsVersion;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'assets-version:clear')]
class AssetsVersionClearCommand extends Command
{
    /**
     * The illuminate filesystem instance.
     *
     * @var Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * The console command name
     *
     * @var string
     */
    protected $name = "assets-version:clear";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear cached assets versions';

    /**
     * Create a new asset version clear command instance.
     *
     * @param Filesystem $filesystem
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $assetsVersion = (
            $this->laravel->make(AssetsVersion::class)
        );

        $this->filesystem->delete(
            $assetsVersion->getVersionFilePath()
        );

        $this->info('Assets version cache cleared!');
    }
}
