<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\{
    Log,
    Storage
};
use Symfony\Component\Console\Command\Command as CommandAlias;

/**
 * Final Class PruneLogs
 */
final class PruneLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prune-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gather the logs from a specific time frame, upload to S3 and delete from server.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        // Look inside the logs folder on the platform
        // Locating anything with a date format after hyphen.
        $logs = collect(glob(storage_path('logs/laravel-*.log')));

        // We will grab each file that is locally stored
        // Sending them to S3 and purging its existence locally.
        $processed = [];
        $logs->each(static function ($log) use (&$processed) {
            // Explode and grab the file name, in order to put
            // Correctly onto S3.
            $explode = explode('/', $log);
            $name = end($explode);

            // Send the files to S3.
            Storage::disk('s3')->put($name, file_get_contents($log));

            // Add the file name to the logs that have been processed.
            $processed[] = $name;

            // Lastly remove the logs locally
            // Be gone!
            Storage::disk('logs')->delete($name);
        });

        // Log out the results and return the command.
        Log::info(
            'Processed Log Pruning',
            [
                'command' => $this->signature,
                'logs'    => $processed,
            ]
        );

        return CommandAlias::SUCCESS;
    }
}
