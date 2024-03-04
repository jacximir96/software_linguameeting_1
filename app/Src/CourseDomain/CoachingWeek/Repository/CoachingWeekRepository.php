<?php

namespace App\Src\CourseDomain\CoachingWeek\Repository;

use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Course\Model\Course;

class CoachingWeekRepository
{
    public function obtainByCourse(Course $course)
    {
        return CoachingWeek::query()
            ->where('course_id', $course->id)
            ->where('is_makeup', 1)
            ->get();
    }

    public function obtainByCourseAndOrder(Course $course, int $order)
    {
        return CoachingWeek::query()
            ->where('course_id', $course->id)
            ->where('is_makeup', 0)
            ->where('session_order', $order)
            ->first();
    }
}
