<?php

namespace App\Src\CourseDomain\CoachingForm\Action\CoachingWeek;

use App\Src\CourseDomain\CoachingForm\Action\CoachingWeekAssignToStudentsSessionsAction;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\CoachingWeek\Repository\CoachingWeekRepository;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\TimeDomain\Date\Service\WeekCalendar;

class EqualWeeksUpdateCommand
{
    private CoachingWeekRepository $coachingWeekRepository;

    private CoachingWeekAssignToStudentsSessionsAction $coachingWeekAssignToStudentsSessionsAction;

    public function __construct(CoachingWeekRepository $coachingWeekRepository, CoachingWeekAssignToStudentsSessionsAction $coachingWeekAssignToStudentsSessionsAction)
    {
        $this->coachingWeekRepository = $coachingWeekRepository;
        $this->coachingWeekAssignToStudentsSessionsAction = $coachingWeekAssignToStudentsSessionsAction;
    }

    public function handle(WeekCalendar $weekCalendar, Course $course)
    {
        $order = 1;

        foreach ($weekCalendar->get() as $period) {
            $coachingWeek = $this->obtainCoachingWeek($course, $order);

            $coachingWeek->start_date = $period->getStartDate();
            $coachingWeek->end_date = $period->getEndDate();
            $coachingWeek->occupation_week = $course->student_class;
            $coachingWeek->is_makeup = false;
            $coachingWeek->save();

            if ($course->isFlex()) {
                $this->coachingWeekAssignToStudentsSessionsAction->handle($course, $coachingWeek);
            }

            $order++;
        }
    }

    private function obtainCoachingWeek(Course $course, int $order): CoachingWeek
    {
        $coachingWeek = $this->coachingWeekRepository->obtainByCourseAndOrder($course, $order);

        if ($coachingWeek) {
            return $coachingWeek;
        }

        throw new \Exception('Coaching week not found');
    }
}
