<?php

namespace App\Src\UserDomain\User\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\UserDomain\User\Model\User;

class EditInstructorAlertForm extends BaseSearchForm
{

    const SLUG = 'alerts_edit';

    public function __construct()
    {
        
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function config(User $instructor)
    {
        $this->isEdit = true;

        $this->action = route('post.instructor.alerts.edit');

        $this->configModel($instructor);

        $this->configOptions();
    }

    private function configModel(User $instructor)
    {

        $this->model = [];
        $this->model['active'] = true;

        $this->model = $instructor->toArray();

    }

    private function configOptions()
    {


    }
}
