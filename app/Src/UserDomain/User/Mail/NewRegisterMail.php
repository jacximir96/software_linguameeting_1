<?php

namespace App\Src\UserDomain\User\Mail;

use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewRegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    private Enrollment $enrollment;

    private User $user;

    public function __construct(Enrollment $enrollment)
    {
        $this->enrollment = $enrollment;
        $this->user = $enrollment->user;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'New account in LinguaMeeting'
        );
    }

    public function content()
    {
        return new Content(
            view: 'user.email.new_register_email',
            with: [
                'name' => $this->user->name,
            ],
        );
    }

    public function attachments()
    {
        return [];
    }
}
