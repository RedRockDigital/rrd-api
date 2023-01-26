<?php

namespace RedRockDigital\Api\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use RedRockDigital\Api\Database\Seeders\Local\LocalSeeder;
use RedRockDigital\Api\Database\Seeders\Production\ProductionSeeder;
use RedRockDigital\Api\Database\Seeders\Staging\StagingSeeder;

class InstallCommand extends Command
{
    /**
     * @var string[]
     */
    protected array $seeders = [
        'local'      => LocalSeeder::class,
        'staging'    => StagingSeeder::class,
        'production' => ProductionSeeder::class,
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install {--env= : The env to seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Application setup for migrations, oauth and seeders';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if (!file_exists(storage_path('oauth-public.key'))) {
            $this->call('passport:keys');
        }

        $this->call('migrate:fresh', [
            '--force' => null,
        ]);

        $this->call('passport:client', [
            '--password'       => null,
            '--no-interaction' => true,
        ]);

        $this->call('passport:client', [
            '--personal'       => null,
            '--no-interaction' => true,
        ]);

        if (config('app.env') === 'local') {
            if (getenv('VITE_CLIENT_ID') && getenv('VITE_CLIENT_SECRET')) {
                // Force oauth secret to the value in the .env
                DB::table('oauth_clients')
                    ->where('id', getenv('VITE_CLIENT_ID'))
                    ->update([
                        'secret' => getenv('VITE_CLIENT_SECRET'),
                    ]);

                $this->warn('Oauth client secret has been reset to: '.getenv('VITE_CLIENT_SECRET'));
            } else {
                $this->warn(
                    'Your \'VITE_CLIENT_ID\' and \'VITE_CLIENT_SECRET\' has not been set yet, and '.
                    'haven\'t been persisted'
                );
            }
        }

        if ($env = $this->option('env')) {
            if (array_key_exists($env, $this->seeders)) {
                (new $this->seeders[$env])->run();
            } else {
                $this->error(
                    'Invalid env provided. Please choose one of the following: '.
                    implode(', ', array_keys($this->seeders))
                );
            }
        }
    }
}
