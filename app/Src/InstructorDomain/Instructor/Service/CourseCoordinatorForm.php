<?php

namespace App\Src\InstructorDomain\Instructor\Service;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Shared\Service\BaseSearchForm;

class CourseCoordinatorForm extends BaseSearchForm
{
    public function configToCreate(Course $course)
    {
        $this->action = route('post.common.course.course_coordinator.create', $course->hashId());

        $this->model = [];
        $this->model['active'] = true;
    }
}
