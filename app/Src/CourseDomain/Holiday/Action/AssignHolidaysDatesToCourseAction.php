<?php

namespace App\Src\CourseDomain\Holiday\Action;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Holiday\Model\Holiday;
use App\Src\CourseDomain\Holiday\Model\HolidaysDates;

class AssignHolidaysDatesToCourseAction
{
    public function handle(Course $course, HolidaysDates $holidaysDates)
    {
        foreach ($holidaysDates->get() as $date) {
            $holiday = new Holiday();
            $holiday->course_id = $course->id;
            $holiday->date = $date->toDateString();

            $holiday->save();
        }
    }
}
