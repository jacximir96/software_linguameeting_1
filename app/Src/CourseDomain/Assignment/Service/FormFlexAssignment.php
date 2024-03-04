<?php

namespace App\Src\CourseDomain\Assignment\Service;

use App\Src\CourseDomain\Assignment\Repository\AssignmentRepository;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class FormFlexAssignment extends BaseSearchForm
{
    use Placeholderable;

    private FieldFormBuilder $fieldFormBuilder;

    private AssignmentRepository $assignmentRepository;

    public function __construct(FieldFormBuilder $fieldFormBuilder, AssignmentRepository $assignmentRepository)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->assignmentRepository = $assignmentRepository;
    }

    public function config(Section $section, int $sessionOrder)
    {

        $this->action = route('post.common.course.assignment.flex.update', [$section->id, $sessionOrder]);
        $this->model = [];

        $assignment = $this->assignmentRepository->findBySectionAndFlexOrderOrNull($section, $sessionOrder);

        if ($assignment) {
            $this->model = $assignment->toArray();
        }

    }
}
