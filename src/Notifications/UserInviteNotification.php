<?php

namespace RedRockDigital\Api\Notifications;

use RedRockDigital\Api\Models\Team;
use RedRockDigital\Api\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class UserInviteNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param  bool  $new
     * @param  Team  $team
     * @param  User  $invitedBy
     */
    public function __construct(public bool $new, public Team $team, public User $invitedBy)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        $message = (new MailMessage())
            ->subject(
                Lang::get('You\'ve been invited to join your colleagues on :appname', [
                    'appname' => config('app.name'),
                ])
            )
            ->line(
                Lang::get('Your colleague :colleague has invited you to join your team :team on :appname.', [
                    'colleague' => $this->invitedBy->full_name,
                    'team'      => $this->team->name,
                    'appname'   => config('app.name'),
                ])
            );

        if ($this->new) {
            return $message->line(Lang::get('To get started, create your new account below.'))
                ->action(Lang::get('Create Account'), $notifiable->getVerificationUrl());
        }

        return $message->line(Lang::get('Simply sign into your existing account and switch team from the user menu.'))
            ->action(Lang::get('Sign In'), config('app.url'));
    }
}
