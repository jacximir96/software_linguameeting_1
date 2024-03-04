<?php

namespace App\Src\UserDomain\User\Mail;

use App\Src\Shared\Model\ValueObject\EmailContent;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SimpleMailUser extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    public EmailContent $emailContent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, EmailContent $emailContent)
    {
        //
        $this->user = $user;
        $this->emailContent = $emailContent;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->emailContent->subject(),
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'user.email.simple_email',
            with: [
                'name' => $this->user->name,
                'body' => $this->emailContent->body(),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
