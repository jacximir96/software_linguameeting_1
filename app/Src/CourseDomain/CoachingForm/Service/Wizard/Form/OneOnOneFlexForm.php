<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Form;

use App\Src\CourseDomain\Assignment\Repository\AssignmentRepository;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class OneOnOneFlexForm extends BaseSearchForm
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

    public function config(Course $course)
    {
        $this->action = route('post.admin.course.coaching_form.course_assignment.update.flex.one_on_one', $course);

        $this->initializeModel();

        $this->configModel($course);
    }

    private function initializeModel()
    {
        $this->model['chapter_id'] = [];
    }

    private function configModel(Course $course)
    {

        foreach ($course->section as $section) {
            foreach ($section->assignment as $assignment) {

                if ($assignment->chapter) {
                    $key = $section->id.'-'.$assignment->session_order;
                    $this->model['chapter_id'][$key] = $assignment->chapter->chapter_id;
                }
            }
        }
    }
}
