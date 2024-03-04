<?php

namespace App\Src\CourseDomain\Assignment\Service;

use App\Src\CourseDomain\Assignment\Repository\AssignmentRepository;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class FormWeekAssignment extends BaseSearchForm
{
    use Placeholderable;

    private FieldFormBuilder $fieldFormBuilder;

    private AssignmentRepository $assignmentRepository;

    public function __construct(FieldFormBuilder $fieldFormBuilder, AssignmentRepository $assignmentRepository)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->assignmentRepository = $assignmentRepository;
    }

    public function config(Section $section, CoachingWeek $coachingWeek)
    {

        $this->action = route('post.common.course.assignment.week.update', [$section->id, $coachingWeek->id]);
        $this->model = [];

        $assignment = $this->assignmentRepository->findBySectionAndCoachingWeekOrNull($section, $coachingWeek);

        if ($assignment) {
            $this->model = $assignment->toArray();
        }

    }
}
