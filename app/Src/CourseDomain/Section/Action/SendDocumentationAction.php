<?php

namespace App\Src\CourseDomain\Section\Action;

use App\Src\ActivityLog\Service\Properties\PropertyBuilder;
use App\Src\CourseDomain\Course\Service\CourseFiles;
use App\Src\CourseDomain\Section\Mail\SectionDocumentationMail;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\File\Service\Attachments;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Spatie\Activitylog\Models\Activity;

class SendDocumentationAction
{
    private Section $section;

    private Collection $recipients;

    private Attachments $attachments;

    private CourseFiles $courseFiles;


    public function __construct(CourseFiles $courseAttachments, Attachments $attachments)
    {
        $this->courseFiles = $courseAttachments;
        $this->attachments = $attachments;
    }

    public function handle(Section $section, User $sender)
    {

        $this->initialize($section);

        $this->configRecipients();

        $this->configAttachments();

        $this->send($sender);
    }

    private function initialize(Section $section)
    {

        $this->section = $section;
        $this->recipients = collect();
    }

    private function configRecipients()
    {

        $this->recipients->push($this->section->instructor);
    }

    private function configAttachments()
    {

        $attachment = $this->courseFiles->obtainCourseSummaryAsAttachment($this->section->course);
        $this->attachments->push($attachment);

        $attachment = $this->courseFiles->obtainSectionInstructionsAsAttachment($this->section);
        $this->attachments->push($attachment);
    }

    private function send(User $sender)
    {

        foreach ($this->recipients as $recipient) {

            Mail::to($recipient->email)
                ->queue((new SectionDocumentationMail($this->section, $recipient, $this->attachments))->onQueue('emails'));

            $this->registerActivity($recipient);
        }
    }

    private function registerActivity(User $recipient):Activity
    {

        $properties =  array_merge(
            PropertyBuilder::buildIp(request()->ip())->buildProperty('ip'),
            PropertyBuilder::buildUser($recipient)->buildProperty('recipient', 'Recipient'),
        );

        return activity()
            ->causedBy(user())
            ->performedOn($this->section)
            ->withProperties($properties)
            ->log(config('linguameeting_log.activity.keys.section.send_documentation'));
    }
}
