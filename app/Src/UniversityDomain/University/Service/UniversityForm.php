<?php

namespace App\Src\UniversityDomain\University\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UniversityDomain\University\Model\University;

class UniversityForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $countryOptions;

    private array $timezoneOptions;

    private array $levelOptions;

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

    public function levelOptions(): array
    {
        return $this->levelOptions;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configToCreate()
    {
        $this->action = route('post.admin.university.create');

        $this->model = [];
        $this->model['active'] = true;
        $this->model['max_experiences'] = 0;

        $this->configCommonOptions();
    }

    public function configToEdit(University $university)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.university.edit', $university->hashId());

        $this->model = $university->toArray();

        $this->configCommonOptions();
    }

    private function configCommonOptions()
    {
        $this->countryOptions = $this->fieldFormBuilder->obtainCountryOptions();

        $this->timezoneOptions = $this->fieldFormBuilder->obtainTimezonesOptions();

        $this->levelOptions = $this->fieldFormBuilder->obtainUniversityLevelOptions();
    }
}
