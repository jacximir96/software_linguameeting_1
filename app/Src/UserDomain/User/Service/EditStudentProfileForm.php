<?php

namespace App\Src\UserDomain\User\Service;

use App\Src\CoachDomain\Coach\Service\CoachableForm;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class EditStudentProfileForm extends BaseSearchForm
{
    use CoachableForm;

    const SLUG = 'profile_edit';

    private FieldFormBuilder $fieldFormBuilder;

    private array $countryOptions;

    private array $timezoneOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function config(User $student)
    {
        $this->isEdit = true;

        $this->action = route('post.student.profile.edit');

        $this->configModel($student);

        $this->configOptions();
    }

    private function configModel(User $student)
    {

        $this->model = [];
        $this->model['active'] = true;

        $this->model = $student->toArray();

        $this->model['country_id'] = $student->country_id ?? null;
        $this->model['country_live_id'] = $student->country_live_id ?? null;

    }

    private function configOptions()
    {

        $this->countryOptions = $this->fieldFormBuilder->obtainCountryOptions();

        $this->timezoneOptions = $this->fieldFormBuilder->obtainTimezonesOptions();

    }
}
