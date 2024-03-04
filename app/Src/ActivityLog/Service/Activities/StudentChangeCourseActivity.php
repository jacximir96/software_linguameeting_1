<?php

namespace App\Src\ActivityLog\Service\Activities;

use App\Src\ActivityLog\Exception\SubjectTypeNotValid;
use App\Src\ActivityLog\Service\Formatter\FormatterBuilder;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Enrollment\Repository\EnrollmentRepository;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Models\Activity;


class StudentChangeCourseActivity implements \App\Src\ActivityLog\Service\Activities\Activity
{
    use Printable;

    private Enrollment $enrollment;

    private Activity $activity;

    public function __construct(Activity $activity)
    {

        $this->checkSubjectType($activity);
        $this->activity = $activity;
        $this->enrollment = EnrollmentRepository::findTrashed($activity->subject_id);

    }

    public function activity(): Activity
    {
        return $this->activity;
    }

    public function nameModel(): string
    {
        return 'Enrollment';
    }

    public function formattedProperties():Collection{
        $properties = $this->activity->properties();

        $formatter = app(FormatterBuilder::class);
        $formatedData = $formatter->buildFormatters($properties);

        return $formatedData;
    }

    public function trans ():string{
        return $this->activity->trans().': '.$this->enrollment->name;
    }

    private function checkSubjectType(Activity $activity)
    {
        if ($activity->subject_type != Enrollment::MORPH) {
            throw new SubjectTypeNotValid();
        }
    }
}
