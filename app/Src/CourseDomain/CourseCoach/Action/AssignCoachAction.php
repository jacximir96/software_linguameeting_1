<?php

namespace App\Src\CourseDomain\CourseCoach\Action;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Request\AssignCoachRequest;
use App\Src\CourseDomain\CourseCoach\Model\CourseCoach;

class AssignCoachAction
{
    public function handle(AssignCoachRequest $request, Course $course): CourseCoach
    {

        $item = new CourseCoach();
        $item->course_id = $course->id;
        $item->coach_id = $request->coach_id;
        $item->save();

        return $item;
    }
}
