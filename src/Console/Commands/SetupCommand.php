<?php

namespace RedRockDigital\Api\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class SetupCommand extends Command
{
    /**
     * The path to a file that we can use to check if the package has been previously installed
     * @var string
     */
    private string $installCheckFile = 'js/Components/AppClient.jsx';

    /**
     * Holds the value for the stubs path
     * @var string
     */
    private string $packageStubDirectory;

    /**
     * Whether this script is running for the first time for a new install
     * @var bool
     */
    private bool $isFirstInstall = true;

    /**
     * An array of files that need to be manually reviewed after an update has been performed.
     * @var array
     */
    private array $filesToManuallyReview = [];

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
     * @constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->packageStubDirectory = dirname(__FILE__) . '/../../../stubs';
        $this->isFirstInstall = $this->isFirstInstall();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if ($this->isFirstInstall || $this->option('reinstall')) {
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
        if ($this->option('reinstall') && !$this->isFirstInstall) {
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

        $fs = new Filesystem();

        // Remove the current resource's folder, we're about to create our own
        $fs->deleteDirectory(resource_path());

        // Copy each of the files from the stubs directory into the correct location
        collect($fs->allFiles($this->packageStubDirectory, true))
            ->each(function ($file) use ($fs) {
                $destination = ltrim(Str::after($file->getPath(), $this->packageStubDirectory), '/');

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

        $this->runYarn();
    }

    /**
     * Reviews files in the package against those in the app to determine if there is an update.
     *
     * @return void
     */
    private function performUpdate(): void
    {
        $this->warn("Files are updating. Please note that this will not remove any files");

        if (!$this->askToContinue()) {
            return;
        }

        $fs = new Filesystem();

        collect($fs->allFiles($this->packageStubDirectory, true))
            ->each(function ($file) use ($fs) {
                $destination = ltrim(Str::after($file->getPath(), $this->packageStubDirectory), '/');
                $fileName = $file->getFilename();
                $fileInDestination = base_path((!empty($destination) ? $destination . '/' : '') . $fileName);

                if ($fs->isFile($fileInDestination)) {
                    // Check for update, skip if hashes are the same
                    if ($fs->hasSameHash($file->getPath() . '/' . $file->getFilename(), $fileInDestination)) {
                        $this->info("No change detected in " . $fileInDestination);
                    } else {
                        // We don't want to assume the file should be updated if heavy customisation has been done
                        // so ask the user if they want the file to be updated. If not, they will have to manually
                        // update in their IDE.
                        $this->info("File has changed and needs updating " . $fileInDestination);

                        if ($this->askToContinue()) {
                            $fs->copy($file->getPath() . '/' . $file->getFilename(), $fileInDestination);
                            $this->warn("File has been updated " . $fileInDestination);
                        } else {
                            // Add the files that are skipped so that we can provide a list of files that need to be
                            // reviewed manually by the user.
                            $this->filesToManuallyReview[] = [
                                $file->getPath() . '/' . $file->getFilename(),
                                $fileInDestination,
                            ];
                            $this->warn("Skipping file update " . $fileInDestination);
                        }
                    }
                } else {
                    if (!$fs->isDirectory(base_path($destination))) {
                        $fs->makeDirectory(base_path($destination), 0755, true);
                    }

                    $fs->copy($file->getPath() . '/' . $file->getFilename(), $fileInDestination);

                    $this->info("Created new file " . $fileInDestination);
                }
            });

        $this->runYarn();

        if ($this->filesToManuallyReview) {
            $this->table(['Package File', 'App File'], $this->filesToManuallyReview);
        }
    }

    /**
     * Check if we're performing an installation for the first time.
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

    /**
     * Executes a yarn install for the package
     *
     * @return void
     */
    private function runYarn(): void
    {
        $this->info('Yarn needs to be installed in order for the app to function and build');

        if (!$this->askToContinue()) {
            return;
        }

        $this->warn('This may take a moment or two...');

        exec('yarn install');
    }
}
