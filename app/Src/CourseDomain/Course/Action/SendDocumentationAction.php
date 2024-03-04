<?php

namespace App\Src\CourseDomain\Course\Action;

use App\Src\ActivityLog\Service\Properties\PropertyBuilder;
use App\Src\CourseDomain\Course\Mail\CourseDocumentationMail;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Service\CourseFiles;
use App\Src\File\Service\Attachments;
use App\Src\InstructorDomain\Instructor\Repository\InstructorRepository;
use App\Src\UserDomain\Role\Service\FactoryRole;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Spatie\Activitylog\Models\Activity;

class SendDocumentationAction
{
    private Course $course;

    private Collection $recipients;

    private CourseFiles $courseFiles;

    private \App\Src\CourseDomain\Section\Action\SendDocumentationAction $sendSectionDocumentationAction;

    private InstructorRepository $instructorRepository;


    private FactoryRole $factoryRole;

    private Attachments $attachments;

    public function __construct(CourseFiles $courseAttachments,
        \App\Src\CourseDomain\Section\Action\SendDocumentationAction $sendSectionDocumentationAction,
        InstructorRepository $instructorRepository,
        FactoryRole $factoryRole,
        Attachments $attachments)
    {
        $this->courseFiles = $courseAttachments;
        $this->sendSectionDocumentationAction = $sendSectionDocumentationAction;
        $this->instructorRepository = $instructorRepository;
        $this->factoryRole = $factoryRole;
        $this->recipients = collect();
        $this->attachments = $attachments;
    }

    public function handle(Course $course, User $sender)
    {

        $this->initialize($course);

        $this->configCoordinatorsRecipients();

        $this->configAttachemtns();

        $this->sendCourseDocumentation($sender);
    }

    private function initialize(Course $course)
    {
        $this->course = $course;
        $this->recipients = collect();
    }

    private function configCoordinatorsRecipients()
    {

        $this->assignCourseCoordinatorRecipient();

        $this->assignCoordinatorsRecipients();
    }

    private function assignCourseCoordinatorRecipient()
    {

        foreach ($this->course->coordinator as $courseCoordinator) {
            $this->recipients->push($courseCoordinator->coordinator);
        }
    }

    private function assignCoordinatorsRecipients()
    {

        $languageCourse = $this->course->language;

        $coordinatorRol = $this->factoryRole->obtainCoordinator();
        $coordinators = $this->instructorRepository->obtainByUniversityAndRole($this->course->university, $coordinatorRol);

        foreach ($coordinators as $coordinator) {

            if ($coordinator->hasLanguage($languageCourse)) {
                $this->recipients->push($coordinator);
            }
        }
    }

    private function configAttachemtns()
    {

        $attachment = $this->courseFiles->obtainCourseSummaryAsAttachment($this->course);
        $this->attachments->push($attachment);

        foreach ($this->course->section as $section) {
            $attachment = $this->courseFiles->obtainSectionInstructionsAsAttachment($section);
            $this->attachments->push($attachment);
        }
    }

    private function sendCourseDocumentation(User $sender)
    {

        foreach ($this->recipients as $recipient) {

            $email = new CourseDocumentationMail($this->course, $recipient, $this->attachments);
            $email->onQueue('emails');

            Mail::to($recipient->email)->queue($email);

            $this->registerActivity($recipient);
        }
    }

    private function registerActivity(User $recipient):Activity
    {

        $properties =  array_merge(
            PropertyBuilder::buildIp(request()->ip())->buildProperty('ip'),
            PropertyBuilder::buildUser($recipient)->buildProperty('recipient', 'Recipient'),
        );

        return  activity()
            ->causedBy(user())
            ->performedOn($this->course)
            ->withProperties($properties)
            ->log(config('linguameeting_log.activity.keys.course.send_documentation'));
    }
}
