<?php

namespace App\Src\CourseDomain\Course\Action;


use App\Src\ActivityLog\Service\Properties\PropertyBuilder;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Service\CourseFiles;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Spatie\Activitylog\Models\Activity;

//enviado cuando finaliza el coaching form
class SendSummaryAction
{
    private CourseFiles $courseFiles;


    public function __construct(CourseFiles $courseFiles)
    {

        $this->courseFiles = $courseFiles;
    }

    public function handle(Course $course, User $recipient)
    {

        $courseSummaryFile = $this->courseFiles->obtainCourseSummaryPdf($course);

        $sectionsInstructionsFiles = $this->obtainSectionsInstructions($course);

        //return Mail::render
        Mail::send('email.registered.course.course_summary', ['user' => user()], function ($message) use ($course, $recipient, $courseSummaryFile, $sectionsInstructionsFiles) {
            $message->to($recipient->email, $recipient->name)->subject('Course '.$course->name);

            $message->from('from@gmail.com', 'Linguameeting');

            $message->attachData($courseSummaryFile->output(), $course->summaryFilename());

            foreach ($sectionsInstructionsFiles as $file) {
                $message->attachData($file['file']->output(), $file['filename']);
            }
        });

        $this->registerActivity($course, $recipient);
    }

    private function obtainSectionsInstructions(Course $course): Collection
    {
        $files = collect();

        foreach ($course->section as $section) {

            $pdf = $this->courseFiles->obtainSectionInstructionsPdf($section);

            $file = [
                'file' => $pdf,
                'filename' => $section->instructionsFilename(),
            ];

            $files->push($file);
        }

        return $files;
    }

    private function registerActivity(Course $course, User $recipient):Activity
    {

        $properties =  array_merge(
            PropertyBuilder::buildIp(request()->ip())->buildProperty('ip'),
            PropertyBuilder::buildUser($recipient)->buildProperty('recipient', 'Recipient'),
        );

        return  activity()
            ->causedBy(user())
            ->performedOn($course)
            ->withProperties($properties)
            ->log(config('linguameeting_log.activity.keys.course.send_documentation'));
    }
}
