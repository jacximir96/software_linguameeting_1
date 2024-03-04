<?php

namespace App\Src\CourseDomain\CoachingForm\Action;

use App\Src\CourseDomain\CoachingForm\Request\CoachingWeeksRequest;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Course\Model\Course;
use Carbon\Carbon;

class MakeUpWeekUpdateAction
{
    public function handle(CoachingWeeksRequest $request, Course $course): CoachingWeek
    {
        $makeUpWeek = $this->obtainMakeUpWeek($course);

        $makeUpWeek->start_date = Carbon::parse($request->startDateMake);
        $makeUpWeek->end_date = Carbon::parse($request->dueDateMake);
        $makeUpWeek->session_order = 0;
        $makeUpWeek->occupation_week = $course->student_class;
        $makeUpWeek->is_makeup = 1;
        $makeUpWeek->save();

        return $makeUpWeek;
    }

    private function obtainMakeUpWeek(Course $course): CoachingWeek
    {
        $makeUpWeek = $this->obtainExistsMakupWeekFromCourseOrNull($course);

        if ($makeUpWeek) {
            return $makeUpWeek;
        }

        $makeUpWeek = new CoachingWeek();
        $makeUpWeek->course_id = $course->id;

        return $makeUpWeek;
    }

    private function obtainExistsMakupWeekFromCourseOrNull(Course $course): ?CoachingWeek
    {
        return CoachingWeek::query()
            ->where('course_id', $course->id)
            ->where('is_makeup', 1)
            ->first();
    }
}
