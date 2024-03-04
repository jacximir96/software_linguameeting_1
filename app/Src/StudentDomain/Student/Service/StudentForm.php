<?php

namespace App\Src\StudentDomain\Student\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class StudentForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $countryOptions;

    private array $timezoneOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function countryOptions(): array
    {
        return $this->countryOptions;
    }

    public function timezoneOptions(): array
    {
        return $this->timezoneOptions;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configToCreate()
    {
        $this->action = route('post.admin.student.create');

        $this->model = [];
        $this->model['active'] = true;

        $this->configCommonOptions();
    }

    public function configToEdit(User $student)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.student.update', $student);

        $this->configModel($student);

        $this->configCommonOptions();
    }

    private function configModel(User $coach)
    {
        $this->model = $coach->toArray();
        $this->model['password'] = '';
        $this->model['country_id'] = $coach->country_id ?? null;
    }

    private function configCommonOptions()
    {
        $this->countryOptions = $this->fieldFormBuilder->obtainCountryOptions();

        $this->timezoneOptions = $this->fieldFormBuilder->obtainTimezonesOptions();

    }
}
