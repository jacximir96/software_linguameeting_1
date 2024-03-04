<?php

namespace App\Src\ExperienceDomain\Experience\Service;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\Shared\Service\BaseSearchForm;

class RegisterStudentFreeForm extends BaseSearchForm
{
    public function config(Experience $experience)
    {
        $this->action = route('post.experience.register.free', $experience->hashId());

        $this->model = [];
        $this->model['amount'] = '';
    }
}
