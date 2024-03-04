<?php
namespace App\Src\InstructorDomain\Instructor\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;


class PublicRegisterForm extends BaseSearchForm
{

    //status
    private array $countriesOptions = [];

    private array $universitiesOptions = [];

    private array $timezonesOptions = [];

    private array $languagesOptions = [];

    //construct
    private FieldFormBuilder $fieldFormBuilder;


    public function __construct (FieldFormBuilder $fieldFormBuilder){

        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function config()
    {
        $this->action = route('post.public.register.instructor.create');

        $this->model = [];

        $this->configOptions();
    }

    private function configOptions (){

        $this->countriesOptions = $this->fieldFormBuilder->obtainCountryOptions();

        $this->universitiesOptions = $this->fieldFormBuilder->obtainUniversityOptions();

        $this->timezonesOptions = $this->fieldFormBuilder->obtainTimezonesOptions();

        $this->languagesOptions = $this->fieldFormBuilder->obtainLanguageOptions('id');
    }
}
