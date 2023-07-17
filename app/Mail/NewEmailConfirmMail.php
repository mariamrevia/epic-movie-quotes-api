<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Message;
use Illuminate\Queue\SerializesModels;

class NewEmailConfirmMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $verificationUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(string $verificationUrl)
    {
        $this->verificationUrl = $verificationUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirm Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function build(): NewEmailConfirmMail
    {
        return
        $this->markdown('confirm-new-mail')
        ->with(['verificationUrl' => $this->verificationUrl]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
