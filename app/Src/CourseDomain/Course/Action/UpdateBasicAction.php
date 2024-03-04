<?php

namespace App\Src\CourseDomain\Course\Action;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Request\CourseBasicRequest;

class UpdateBasicAction
{
    public function handle(CourseBasicRequest $request, Course $course): Course
    {

        $course->level_id = $request->level_id;
        $course->student_class = $request->student_class;

        $course->save();

        return $course;
    }
}
