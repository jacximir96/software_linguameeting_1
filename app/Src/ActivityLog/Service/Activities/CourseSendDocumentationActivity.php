<?php

namespace App\Src\ActivityLog\Service\Activities;

use App\Src\ActivityLog\Exception\SubjectTypeNotValid;
use App\Src\ActivityLog\Service\Formatter\FormatterBuilder;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\UserDomain\User\Model\User;
use App\Src\UserDomain\User\Repository\UserRepository;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Models\Activity;


class CourseSendDocumentationActivity implements \App\Src\ActivityLog\Service\Activities\Activity
{
    use Printable;

    private Course $course;

    private Activity $activity;

    public function __construct(Activity $activity)
    {
        $this->checkSubjectType($activity);

        $this->activity = $activity;
        $this->course = $activity->subject;
    }

    public function activity(): Activity
    {
        return $this->activity;
    }

    public function nameModel(): string
    {
        return 'Course';
    }

    public function trans ():string{
        return $this->activity->trans().': '.$this->activity->subject->name;
    }

    public function sender():User{
        return $this->activity->causer;
    }

    public function recipient():User{

        $properties = $this->activity->properties();

        $recipient = $properties->getProperty('recipient');

        return UserRepository::findTrashed($recipient['id']);
    }

    public function formattedProperties():Collection{

        $properties = $this->activity->properties();

        $formatter = app(FormatterBuilder::class);
        $formatedData = $formatter->buildFormatters($properties);

        return $formatedData;
    }

    private function checkSubjectType(Activity $activity)
    {
        if ($activity->subject_type != Course::MORPH) {
            throw new SubjectTypeNotValid();
        }
    }
}
