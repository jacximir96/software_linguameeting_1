<?php

namespace App\Src\ExperienceDomain\ExperienceRegister\Mail;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegister\Model\ExperienceRegister;
use App\Src\Localization\TimeZone\Model\TimeZone;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderEmail extends Mailable
{
    use Queueable, SerializesModels;


    private ExperienceRegister $experienceRegister;

    private TimeZone $timeZone;

    public function __construct(ExperienceRegister $experienceRegister, TimeZone $timeZone)
    {
        $this->experienceRegister = $experienceRegister;
        $this->timeZone = $timeZone;
    }

    public function envelope()
    {
        return new Envelope(
            subject: $this->experienceRegister->title,
        );
    }

    public function content()
    {
        return new Content(
            view: 'email.registered.student.experience.reminder',
            with: [
                'experienceRegister' => $this->experienceRegister,
                'timezone' => $this->timeZone,
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
