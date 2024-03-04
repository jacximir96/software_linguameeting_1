<?php

namespace App\Src\UniversityDomain\University\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class SearchForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $countryOptions;

    private array $timezoneOptions;

    private array $statusOptions;

    private array $lingroOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function countryOptions(): array
    {
        return $this->countryOptions;
    }

    public function lingroOptions(): array
    {
        return $this->lingroOptions;
    }

    public function timezoneOptions(): array
    {
        return $this->timezoneOptions;
    }

    public function statusOptions(): array
    {
        return $this->statusOptions;
    }

    public function config()
    {
        $this->initialize();

        $this->action = route('post.admin.university.search');

        $this->configModelForm('universities_searcher');

        $this->countryOptions = $this->fieldFormBuilder->obtainCountryOptions();

        $this->timezoneOptions = $this->fieldFormBuilder->obtainTimezonesOptions();

        $this->statusOptions = $this->fieldFormBuilder->obtainStatusUniversityOptions();

        $this->lingroOptions = $this->fieldFormBuilder->obtainBooleanOptions();
    }

    private function initialize()
    {

        $this->countryOptions = [];
        $this->timezoneOptions = [];
        $this->statusOptions = [];
        $this->lingroOptions = [];
    }
}
