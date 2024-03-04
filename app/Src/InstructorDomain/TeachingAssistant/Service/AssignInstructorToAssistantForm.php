<?php

namespace App\Src\InstructorDomain\TeachingAssistant\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class AssignInstructorToAssistantForm extends BaseSearchForm
{
    private array $instructorOptions = [];

    private FieldFormBuilder $fieldFormBuilder;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {

        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function instructorOptions(): array
    {
        return $this->instructorOptions;
    }

    public function hasIntructorsForSelect(): bool
    {
        return count($this->instructorOptions());
    }

    public function configToCreate(User $assistant)
    {
        $this->action = route('post.admin.instructor.teaching_assistant.assign_instructor', $assistant->hashId());

        $this->initialize();

        $this->configureInstructionsOptions($assistant);
    }

    public function initialize()
    {
        $this->model = [];
        $this->instructorOptions = [];
    }

    private function configureInstructionsOptions(User $assistant)
    {

        $this->instructorOptions = $this->fieldFormBuilder->obtainInstructorsOptionsByUniversity($assistant->university->first());

        unset($this->instructorOptions[$assistant->id]);

    }
}
