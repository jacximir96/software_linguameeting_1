<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Form;

use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\Assignment\Repository\AssignmentRepository;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class SectionAssignmentForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private Section $section;

    private User $user;

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

    public function config(Section $section, User $user)
    {
        $this->section = $section;
        $this->user = $user;
        $this->action = route('post.admin.course.coaching_form.course_assignment.update.week.one_on_one', $section);
        $this->action = 'ruta_no_existente';

        $this->initializeModel();

        $this->configModel($section);
    }

    private function initializeModel()
    {
        $this->model['chapter_id'] = [];
        $this->model['assignment'] = [];
        $this->model['students_access'] = [];
        $this->model['instructions'] = [];
        $this->model['instructions_students'] = [];
    }

    private function configModel(Section $section)
    {

        $assignments = $section->assignment;

        if (! $assignments->count()) {
            return;
        }

        foreach ($assignments as $assignment) {

            $key = $assignment->isFlex() ? $assignment->session_order : $assignment->week_id;

            $this->configSessionItem($assignment, $key);
        }
    }

    private function configSessionItem(Assignment $assignment, int $key): void
    {

        $this->model['chapter_id'][$key] = null;

        if ($this->section->withGuide()) {
            if ($assignment->chapter) {
                $this->model['chapter_id'][$key] = $assignment->chapter->chapter_id;
            }
        }
    }
}
