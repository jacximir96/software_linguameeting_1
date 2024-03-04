<?php

namespace App\Src\StudentDomain\Enrollment\Service;


use App\Src\Shared\Service\BaseSearchForm;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;


class ChangeSectionForm extends BaseSearchForm
{


    public function config(Enrollment $enrollment)
    {
        $this->action = route('post.student.enrollment.change.section', $enrollment->hashId());

        $this->model = [];
    }
}
