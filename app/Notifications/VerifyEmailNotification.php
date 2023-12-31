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

class VerifyEmailNotification extends VerifyEmail
{
    use Queueable;

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

        Log::info($notifiable);
        $redirectUrl = config('app.frontend_url');
        $temporarySignedUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification())
            ]
        );

        $signedUrlParts = parse_url($temporarySignedUrl);
        $path = str_replace('/api', '', $signedUrlParts['path']);
        $frontendUrl = $redirectUrl . $path . '?' . $signedUrlParts['query'] . '&verify=true';

        Log::info($frontendUrl);


        return (new EmailConfirmMail($frontendUrl))->to($notifiable);
    }



}
