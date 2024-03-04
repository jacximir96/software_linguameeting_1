<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Form;

use App\Src\CourseDomain\Assignment\Repository\AssignmentRepository;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class OneOnOneFormForAll extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private AssignmentRepository $assignmentRepository;

    public function __construct(FieldFormBuilder $fieldFormBuilder, AssignmentRepository $assignmentRepository)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->assignmentRepository = $assignmentRepository;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function config()
    {
        $this->action = route('post.admin.course.coaching_form.course_assignment.update.flex.one_on_one.for_all');

        $this->model = [];
    }
}
