<?php
namespace App\Src\InstructorDomain\Students\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;


class ChangeSectionFormForm extends BaseSearchForm
{

    public function config(Enrollment $enrollment)
    {
        $this->action = route('post.instructor.students.enrollment.section.change', $enrollment->hashId());

        $this->model = [];
    }
}
