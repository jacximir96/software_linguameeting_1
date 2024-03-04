<?php
namespace App\Src\CoachDomain\Coach\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;


class CoachFrontForm extends BaseSearchForm
{
    use CoachableForm;

    private FieldFormBuilder $fieldFormBuilder;

    private array $countryOptions;

    private array $timezoneOptions;

    private array $languageOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function config()
    {
        $this->action = route('post.public.coach.register.create');

        $this->model = [];

        $this->configCommonOptions();

        $this->configModelNewHobbies();
    }

    private function configCommonOptions()
    {
        $this->countryOptions = $this->fieldFormBuilder->obtainCountryOptions();

        $this->timezoneOptions = $this->fieldFormBuilder->obtainTimezonesOptions();

        $this->languageOptions = $this->fieldFormBuilder->obtainLanguageOptions();
    }
}
