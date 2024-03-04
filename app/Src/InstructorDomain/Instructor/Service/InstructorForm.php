<?php

namespace App\Src\InstructorDomain\Instructor\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class InstructorForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $countryOptions;

    private array $timezoneOptions;

    private array $languageOptions;

    private array $universityOptions;

    private array $roleOptions;

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

    public function languageOptions(): array
    {
        return $this->languageOptions;
    }

    public function universityOptions(): array
    {
        return $this->universityOptions;
    }

    public function roleOptions(): array
    {
        return $this->roleOptions;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configToCreate()
    {
        $this->action = route('post.admin.instructor.create');

        $this->model = [];
        $this->model['active'] = true;

        $this->configCommonOptions();
    }

    public function configToEdit(User $instructor)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.instructor.edit', $instructor->hashId());

        $this->configModel($instructor);
        $this->model['password'] = '';

        $this->configCommonOptions();
    }

    public function configToEditByUser(User $instructor)
    {
        $this->isEdit = true;

        $this->action = route('post.instructor.admin.edit', $instructor->hashId());

        $this->configModel($instructor);
        $this->model['password'] = '';

        $this->configCommonOptions();
    }

    private function configCommonOptions()
    {
        $this->countryOptions = $this->fieldFormBuilder->obtainCountryOptions();

        $this->timezoneOptions = $this->fieldFormBuilder->obtainTimezonesOptions();

        $this->languageOptions = $this->fieldFormBuilder->obtainLanguageOptions();

        $this->universityOptions = $this->fieldFormBuilder->obtainUniversityOptions();

        $this->roleOptions = $this->fieldFormBuilder->obtainInstructorRoleOptions();
    }

    private function configModel(User $instructor)
    {
        $this->model = $instructor->toArray();
        $this->model['role_id'] = $instructor->roles()->first()->id;
        $this->model['language'] = $instructor->language->pluck('id', 'id')->toArray();

        if ($instructor->hasEmailVerified()){
            $this->model['email_verified'] = true;
        }
    }
}
