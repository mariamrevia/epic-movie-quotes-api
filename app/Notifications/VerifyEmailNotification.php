<?php

namespace App\Notifications;

use App\Mail\EmailConfirmMail;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends VerifyEmail
{
    use Queueable;

    public $verificationUrl;

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): EmailConfirmMail
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new EmailConfirmMail($verificationUrl))->to($notifiable);
    }

}
