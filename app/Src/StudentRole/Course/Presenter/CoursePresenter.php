<?php

namespace App\Src\StudentRole\Course\Presenter;

use App\Src\StudentDomain\Enrollment\Model\Enrollment;

class CoursePresenter
{
    public function handle(Enrollment $enrollment): CourseResponse
    {

        return new CourseResponse($enrollment);

    }
}
