<?php

namespace App\Src\CourseDomain\CoachingForm\Action\CoachingWeek;

use App\Src\CourseDomain\CoachingForm\Action\CoachingWeekAssignToStudentsSessionsAction;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\TimeDomain\Date\Service\WeekCalendar;

class WeekCreateCommand
{
    private CoachingWeekAssignToStudentsSessionsAction $assignCoachingWeekToStudentsSessionsAction;

    public function __construct(CoachingWeekAssignToStudentsSessionsAction $assignDuedateToStudentsSessionsAction)
    {
        $this->assignCoachingWeekToStudentsSessionsAction = $assignDuedateToStudentsSessionsAction;
    }

    public function handle(WeekCalendar $weekCalendar, Course $course)
    {
        $order = 1;
        foreach ($weekCalendar->get() as $period) {
            $coachingWeek = new CoachingWeek();
            $coachingWeek->course_id = $course->id;
            $coachingWeek->start_date = $period->getStartDate();
            $coachingWeek->end_date = $period->getEndDate();
            $coachingWeek->session_order = $order;
            $coachingWeek->occupation_week = $course->student_class;

            $coachingWeek->save();
            $order++;

            if ($course->isFlex()) {
                $this->assignCoachingWeekToStudentsSessionsAction->handle($course, $coachingWeek);
            }
        }
    }
}
