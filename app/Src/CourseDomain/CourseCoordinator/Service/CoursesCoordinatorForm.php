<?php

namespace App\Src\CourseDomain\CourseCoordinator\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\UserDomain\User\Model\User;

class CoursesCoordinatorForm extends BaseSearchForm
{
    public function config(User $instructor)
    {
        $this->action = route('post.common.course.course_coordinator.create', $instructor->hashId());

        $this->model = [];
    }
}
