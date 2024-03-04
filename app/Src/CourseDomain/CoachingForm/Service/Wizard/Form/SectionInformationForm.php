<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Form;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UserDomain\User\Model\User;

class SectionInformationForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private Course $course;

    private User $user;

    private array $optionsCoordinators = [];

    private array $optionsTeachingAssistants = [];

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function backStepRoute(): string
    {
        return route('get.admin.course.coaching_form.coaching_weeks', $this->course);
    }

    public function hasCoordinators(): bool
    {
        return (bool) count($this->optionsCoordinators);
    }

    public function hasTeachingAssistant(): bool
    {
        return (bool) count($this->optionsTeachingAssistants);
    }

    public function config(Course $course, User $user)
    {
        $this->initialize($course, $user);

        $this->configModel($course);

        $this->configDropdownOptions($course->university);
    }

    private function initialize(Course $course, User $user)
    {
        $this->course = $course;

        $this->user = $user;

        $this->action = route('post.admin.course.coaching_form.section_information', $course);
    }

    private function configModel(Course $course)
    {
        $this->model = [];

        if ($course->coordinator->count()) {
            $this->model['coordinator_id'] = $course->coordinator->first()->coordinator_id;
        }
    }

    private function configDropdownOptions(University $university)
    {
        $roles = collect(config('linguameeting.user.roles.ids.course_coordinator'));
        $this->optionsCoordinators = $this->fieldFormBuilder->obtainInstructorsOptionsByUniversityAndRole($university, $roles);

        $roles = collect(config('linguameeting.user.roles.ids.teaching_assistant'));
        $this->optionsTeachingAssistants = $this->fieldFormBuilder->obtainInstructorsOptionsByUniversityAndRole($university, $roles);
    }
}
