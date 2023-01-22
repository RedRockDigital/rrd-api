<?php

namespace RedRockDigital\Api\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class SetupCommand extends Command
{
    /**
     * The path to a file that we can use to check if the package has been previously installed.
     * @var string
     */
    private string $installCheckFile = 'js/Components/AppClient.jsx';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rrd:setup 
        {--force : Force operation without interaction}
        {--reinstall : Force reinstall of the package}
        ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Application setup for various required application files';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $isFirstInstall = $this->isFirstInstall();

        if ($isFirstInstall || $this->option('reinstall')) {
            if ($this->option('reinstall') && !$isFirstInstall) {
                $this->warn(
                    'You are installing the package over the top of an existing install. Please proceed with caution.'
                );
            } else {
                $this->warn(
                    'It looks like it\'s your first time installing the package! We\'re going to move some files around' .
                    'delete some others and create lots of new ones.'
                );
            }

            if (!$this->askToContinue()) {
                return;
            }

            $this->performFirstInstall();
        } else {
            $this->performUpdate();
        }
    }

    /**
     * Removes laravel base files and moves our own in place of them.
     *
     * @return void
     */
    private function performFirstInstall(): void
    {
        $packageStubDirectory = dirname(__FILE__) . '/../../../stubs';
        $fs = new Filesystem();

        // Remove the current resource's folder, we're about to create our own
        $fs->deleteDirectory(resource_path());

        collect($fs->allFiles($packageStubDirectory, true))
            ->each(function ($file) use ($packageStubDirectory, $fs) {
                $destination = ltrim(Str::after($file->getPath(), $packageStubDirectory), '/');

                if (!$fs->isDirectory(base_path($destination))) {
                    $fs->makeDirectory(base_path($destination), 0755, true);
                }

                $fileName = $file->getFilename();
                $fs->copy(
                    $file->getPath() . '/' . $file->getFilename(),
                    $fileInDestination = base_path((!empty($destination) ? $destination . '/' : '') . $fileName)
                );

                $this->info("Created new file " . $fileInDestination);
            });

        // Copy all of the file from the stubs folder
    }

    private function performUpdate(): void
    {

    }

    /**
     * Check if we're performing an install for the first time.
     *
     * @return bool
     */
    private function isFirstInstall(): bool
    {
        return !file_exists(resource_path($this->installCheckFile));
    }

    /**
     * Ask the user is they want to continue processing
     *
     * @return bool
     */
    private function askToContinue(): bool
    {
        if (!$this->option('force')) {
            $check = $this->ask('Are you happy to continue?', 'y');

            return $check === 'y';
        }

        return true;
    }
}
