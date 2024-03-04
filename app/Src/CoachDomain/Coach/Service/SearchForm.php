<?php

namespace App\Src\CoachDomain\Coach\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class SearchForm extends BaseSearchForm
{
    const KEY_FORM = 'coach_searcher';

    private FieldFormBuilder $fieldFormBuilder;

    private array $languageOptions;

    private array $roleOptions;

    private array $statusOptions;

    private array $timezoneOptions;

    private array $countryOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function fieldWithOptions(string $field): array
    {
        return $this->$field;
    }

    public function statusOptions(): array
    {
        return $this->statusOptions;
    }

    public function config()
    {
        $this->action = route('post.admin.coach.search');

        $this->configCustomModelForm();

        $this->languageOptions = $this->fieldFormBuilder->obtainLanguageOptions();

        $this->roleOptions = $this->fieldFormBuilder->obtainCoachRoleOptions();

        $this->timezoneOptions = $this->fieldFormBuilder->obtainTimezonesOptions();

        $this->countryOptions = $this->fieldFormBuilder->obtainCountryOptions();

        $this->statusOptions = $this->fieldFormBuilder->obtainStatusUserOptions();
    }

    private function configCustomModelForm(): void
    {
        $statusId = null;
        if (request()->has('status')) {
            $statusId = request()->status;
        }

        if ($statusId) {
            $this->configModelForm(self::KEY_FORM, ['status' => $statusId]);
        } else {
            $this->configModelForm(self::KEY_FORM);
        }
    }
}
