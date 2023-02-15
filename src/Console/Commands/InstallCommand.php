<?php

namespace RedRockDigital\Api\Console\Commands;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RedRockDigital\Api\Seeders\Local\LocalSeeder;
use RedRockDigital\Api\Seeders\Production\ProductionSeeder;
use RedRockDigital\Api\Seeders\Staging\StagingSeeder;

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
    protected $signature = 'rrd:install {--env= : The env to seed}';

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
        // Migrate the database
        $this->call('migrate:fresh', ['--force' => null,]);

        // Install passport and migrate
        $this->installPassport();

        // Install oauth
        $this->installOauth();

        // If the --env option is not provided, we don't need to seed
        if (($env = $this->option('env')) !== null) {
            $this->installEnviorment($env);
        }
    }

    /**
     * Install passport.
     */
    private function installPassport(): void
    {
        // If the oauth keys don't exist, generate them
        if (File::exists(storage_path('oauth-public.key') === false)) {
            $this->call('passport:keys');
        }

        // If the oauth client doesn't exist, generate it
        $this->call('passport:client', [
            '--password'       => null,
            '--no-interaction' => true,
        ]);

        $this->call('passport:client', [
            '--personal'       => null,
            '--no-interaction' => true,
        ]);
    }

    /**
     * Install oauth.
     */
    private function installOauth(): void
    {
        if (config('app.env') === 'local') {
            if (getenv('VITE_CLIENT_ID') && getenv('VITE_CLIENT_SECRET')) {
                // Force oauth secret to the value in the .env
                DB::table('oauth_clients')
                    ->where('id', getenv('VITE_CLIENT_ID'))
                    ->update([
                        'secret' => getenv('VITE_CLIENT_SECRET'),
                    ]);

                $this->warn('Oauth client secret has been reset to: ' . getenv('VITE_CLIENT_SECRET'));
            } else {
                $this->warn(
                    'Your \'VITE_CLIENT_ID\' and \'VITE_CLIENT_SECRET\' has not been set yet, and ' .
                    'haven\'t been persisted'
                );
            }
        }
    }

    /**
     * Seed the database by the env.
     *
     * @param string $env
     */
    private function installEnviorment(string $env)
    {
        // If the env is not in the seeders array, exit
        if (array_key_exists($env, $this->seeders) === false) {
            $this->error(
                'Invalid env provided. Please choose one of the following: ' . implode(', ', array_keys($this->seeders))
            );
            exit;
        }

        // If the env is in the seeders array, run the seeder
        if (isset($this->seeders[$env])) {
            $this->call('db:seed', ['--class' => $seeder = $this->seeders[$env]]);

            // Format the seeder name to match the folder structure
            // e.g. LocalSeeder => Local
            // e.g. StagingSeeder => Staging
            // e.g. ProductionSeeder => Production
            $folder = Str::ucfirst($env);
            $appSeeder = "Database\\Seeders\\{$folder}\\" . class_basename($seeder);

            // From the database/seeders folder, check if the folder exists and the class exists
            // If it does, run it
            if (is_dir("database/seeders/" . $folder) && class_exists($appSeeder)) {
                $this->call('db:seed', ['--class' => $appSeeder]);
            }
        }
    }
}
