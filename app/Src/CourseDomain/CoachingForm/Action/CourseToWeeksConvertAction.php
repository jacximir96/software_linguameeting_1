<?php

namespace App\Src\CourseDomain\CoachingForm\Action;

use App\Src\CourseDomain\CoachingForm\Action\CoachingWeek\DifferentWeeksUpdateCommand;
use App\Src\CourseDomain\CoachingForm\Action\CoachingWeek\EqualWeeksUpdateCommand;
use App\Src\CourseDomain\CoachingForm\Action\CoachingWeek\WeekCreateCommand;
use App\Src\CourseDomain\CoachingForm\Action\CoachingWeek\WeeksDeleteCommand;
use App\Src\CourseDomain\CoachingForm\Request\CoachingWeeksRequest;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\UserDomain\User\Model\User;

class CourseToWeeksConvertAction
{
    private CoachingWeeksRequest $request;

    private Course $course;

    public function handle(CoachingWeeksRequest $request, Course $course): Course
    {
        $this->initialize($request, $course);

        if (! $request->hasDatesSelected()) {
            $command = app(WeeksDeleteCommand::class);
            $command->deleteFromCourse($course);
        } elseif (! $this->courseHasWeeks()) {
            $command = app(WeekCreateCommand::class);
            $command->handle($request->weekCalendar(), $course);
        } elseif ($this->courseWeeksAndSelectedWeeksHasSameNumber()) {
            $command = app(EqualWeeksUpdateCommand::class);
            $command->handle($request->weekCalendar(), $course);
        } elseif ($this->courseWeeksAndSelectedWeeksAreDifferent()) {
            $command = app(DifferentWeeksUpdateCommand::class);
            $command->handle($request->weekCalendar(), $course);
        }

        return $course;
    }

    private function initialize(CoachingWeeksRequest $request, Course $course)
    {
        $this->request = $request;
        $this->course = $course;
    }

    private function courseHasWeeks(): bool
    {
        return $this->course->coachingWeek()->count();
    }

    private function courseWeeksAndSelectedWeeksHasSameNumber(): bool
    {
        $currentCoachingWeeksCount = CoachingWeek::query()
            ->where('course_id', $this->course->id)
            ->where('is_makeup', 0)
            ->count();

        return $currentCoachingWeeksCount == $this->request->numberOfWeeksSelected();
    }

    private function courseWeeksAndSelectedWeeksAreDifferent(): bool
    {
        return ! $this->courseWeeksAndSelectedWeeksHasSameNumber();
    }
}
