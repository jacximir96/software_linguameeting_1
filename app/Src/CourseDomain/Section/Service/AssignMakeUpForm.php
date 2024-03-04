<?php

namespace App\Src\CourseDomain\Section\Service;

use App\Src\CourseDomain\Section\Model\Section;
use App\Src\Shared\Service\BaseSearchForm;

class AssignMakeUpForm extends BaseSearchForm
{
    public function config(Section $section)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.section.make_up.assign', $section->id);

        $this->model['number_makeups'] = 1;

    }
}
