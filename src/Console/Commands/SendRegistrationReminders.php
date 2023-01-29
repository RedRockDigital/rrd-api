<?php

namespace RedRockDigital\Api\Console\Commands;

use RedRockDigital\Api\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendRegistrationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-registration-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Email users who signed up 2 weeks ago and haven't signed up for their accounts.";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::whereNull('email_verified_at')
            ->where('reminded_to_register', false)
            ->where('created_at', '<=', now()->subWeeks(2))
            ->get();

        $users->chunk(1000)->each(function ($users) {
            $users->each(function (User $user) {
                $user->sendEmailVerificationNotification(true);

                $this->info("Reminder sent to {$user->full_name} ({$user->email})");
            });

            DB::table('users')
                ->whereIn('id', $users->pluck('id'))
                ->update([
                    'reminded_to_register' => true,
                ]);
        });

        $this->info('Reminders finished sending to users');

        return 0;
    }
}
