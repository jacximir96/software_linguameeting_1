<?php

namespace App\Src\CourseDomain\Section\Mail;

use App\Src\CourseDomain\Section\Model\Section;
use App\Src\File\Service\Attachments;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SectionDocumentationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Section $section;

    public User $user;

    public $myAttachments;

    public function __construct(Section $section, User $user, Attachments $attachments)
    {
        $this->section = $section;
        $this->user = $user;
        $this->myAttachments = $attachments;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'LinguaMeeting coaching sessions - '.$this->section->course->name_university.' - '.$this->section->course->name,
        );
    }

    public function content()
    {
        return new Content(
            view: 'admin.section.email.documentation',
        );
    }

    public function attachments()
    {
        foreach ($this->myAttachments->get() as $attachment) {

            $attachments[] = Attachment::fromPath($attachment->file()->path())
                ->as($attachment->name())
                ->withMime($attachment->mime());
        }

        return $attachments;
    }
}
