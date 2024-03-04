<?php

namespace App\Src\StudentDomain\Makeup\Service;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\Shared\Service\BaseSearchForm;

class AssignMakeUpByInstructorForm extends BaseSearchForm
{
    public function configForCourse(Course $course)
    {
        $this->isEdit = true;

        $this->action = route('post.instructor.course.makeup.assign', $course->hashId());

        $this->configModel();
    }

    private function configModel()
    {
        $this->model['number_makeups'] = 1;
    }
}
