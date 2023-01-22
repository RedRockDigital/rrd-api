<?php

namespace RedRockDigital\Api\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class VerifyEmailNotification extends Notification
{
    /**
     * @param  bool  $isReminder
     * @param  bool  $emailChanged
     */
    public function __construct(protected bool $isReminder = false, protected bool $emailChanged = false)
    {
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $message = (new MailMessage())
            ->subject(Lang::get('Verify Email Address'));

        if ($this->isReminder) {
            $message
                ->line(Lang::get('Two weeks ago, you signed up for an account on :app. If you would like to continue your registration and try our platform please follow the instructions below. Otherwise, your account will be removed from our system in 2 weeks so that we don\'t bother you again.', [
                    'app' => config('app.name'),
                ]));
        }

        $message
            ->line(Lang::get('Please click the button below to verify your email address.'))
            ->action(Lang::get('Verify Email Address'), $notifiable->getVerificationUrl());

        if ($this->emailChanged) {
            return $message->line(Lang::get('If you did not update your email address, please contact us immediately via '.config('base.support_email')));
        }

        return $message->line(Lang::get('If you did not create an account, no further action is required.'));
    }
}
