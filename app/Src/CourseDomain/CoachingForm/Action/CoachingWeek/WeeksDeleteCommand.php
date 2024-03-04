<?php

namespace App\Src\CourseDomain\CoachingForm\Action\CoachingWeek;

use App\Src\CourseDomain\CoachingWeek\Action\DeleteCoachingWeekAction;
use App\Src\CourseDomain\Course\Model\Course;

class WeeksDeleteCommand
{
    private DeleteCoachingWeekAction $deleteCoachingWeekAction;

    public function __construct(DeleteCoachingWeekAction $deleteCoachingWeekAction)
    {

        $this->deleteCoachingWeekAction = $deleteCoachingWeekAction;
    }

    public function deleteFromCourse(Course $course)
    {

        foreach ($course->coachingWeek as $coachingWeek) {
            $this->deleteCoachingWeekAction->handle($coachingWeek);
        }
    }
}
