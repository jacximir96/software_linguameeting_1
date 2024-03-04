<?php

namespace App\Src\CourseDomain\Course\Mail;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\File\Service\Attachments;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CourseDocumentationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Course $course;

    public User $user;

    public $myAttachments;

    public function __construct(Course $course, User $user, Attachments $attachments)
    {
        $this->course = $course;
        $this->user = $user;
        $this->myAttachments = $attachments;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'LinguaMeeting coaching sessions - '.$this->course->name_university.' - '.$this->course->name,
        );
    }

    public function content()
    {
        return new Content(
            view: 'email.registered.course.documentation',
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
