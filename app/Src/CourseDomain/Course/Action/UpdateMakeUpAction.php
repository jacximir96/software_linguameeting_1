<?php

namespace App\Src\CourseDomain\Course\Action;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Request\MakeUpRequest;

class UpdateMakeUpAction
{
    public function handle(MakeUpRequest $request, Course $course): Course
    {
        $course->number_makeups = $request->number_makeups;
        $course->save();

        return $course;
    }
}
