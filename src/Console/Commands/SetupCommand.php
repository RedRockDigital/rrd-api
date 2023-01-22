<?php

namespace RedRockDigital\BedRock\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SetupCommand extends Command
{
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

    }
}
