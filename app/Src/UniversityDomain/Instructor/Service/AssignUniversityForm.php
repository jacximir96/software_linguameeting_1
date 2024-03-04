<?php

namespace App\Src\UniversityDomain\Instructor\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class AssignUniversityForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $universityOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configToAssign(User $instructor)
    {
        $this->action = route('post.admin.university.instructor.assign', $instructor->hashId());

        $this->model = [];

        $this->configUniversityOptions($instructor);
    }

    private function configUniversityOptions(User $instructor)
    {
        $this->universityOptions = $this->fieldFormBuilder->obtainUniversityOptions();

        foreach ($instructor->university as $university) {
            unset($this->universityOptions[$university->id]);
        }
    }
}
