<?php

namespace App\Src\CourseDomain\CourseCoach\Service;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class AssignCoachForm extends BaseSearchForm
{
    private array $coachesOptions = [];

    private FieldFormBuilder $fieldFormBuilder;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {

        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function coachesOptions(): array
    {
        return $this->coachesOptions;
    }

    public function hasCoachesForSelect(): bool
    {
        return count($this->coachesOptions());
    }

    public function config(Course $course)
    {
        $this->action = route('post.admin.course.coach.assign', $course);

        $this->initialize();

        $this->configureCoachesOptions($course);
    }

    public function initialize()
    {
        $this->model = [];
        $this->coachesOptions = [];
    }

    private function configureCoachesOptions(Course $course)
    {
        $this->coachesOptions = $this->fieldFormBuilder->obtainCoachesOptionsToBeAssignToCourse($course);
    }
}
