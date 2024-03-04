<?php

namespace App\Src\ExperienceDomain\ExperienceRegisterPublic\Mail;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Model\ExperienceRegisterPublic;
use App\Src\Localization\TimeZone\Model\TimeZone;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PublicReminderEmail extends Mailable
{
    use Queueable, SerializesModels;


    private ExperienceRegisterPublic $experienceRegisterPublic;

    private TimeZone $timeZone;

    public function __construct(ExperienceRegisterPublic $experienceRegisterPublic, TimeZone $timeZone)
    {
        $this->experienceRegisterPublic = $experienceRegisterPublic;
        $this->timeZone = $timeZone;
    }

    public function envelope()
    {
        return new Envelope(
            subject: $this->experienceRegisterPublic->experience->title,
        );
    }

    public function content()
    {
        return new Content(
            view: 'email.public.experience.reminder',
            with: [
                'experienceRegisterPublic' => $this->experienceRegisterPublic,
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
