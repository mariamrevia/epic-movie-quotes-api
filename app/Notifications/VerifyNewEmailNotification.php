<?php

namespace App\Notifications;

use App\Mail\EmailConfirmMail;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class VerifyNewEmailNotification extends VerifyEmail
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    protected $newEmail;

    public function __construct($newEmail)
    {
        $this->newEmail = $newEmail;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }


    public function toMail($notifiable):EmailConfirmMail
    {


        $redirectUrl = config('app.frontend_url') ;
        $temporarySignedUrl = URL::temporarySignedRoute(
            'email_verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($this->newEmail),
                'new_email' => $this->newEmail,
            ]
        );

        $signedUrlParts = parse_url($temporarySignedUrl);
        $path = str_replace('/api', '', $signedUrlParts['path']);
        $frontendUrl =  $redirectUrl . $path . '?' . $signedUrlParts['query'];


        return (new EmailConfirmMail($frontendUrl))
        ->to($this->newEmail)
        ->subject('Confirm Mail');
    }



}
