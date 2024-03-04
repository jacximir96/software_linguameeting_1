<?php

namespace App\Src\CourseDomain\CoachingForm\Action;

use App\Src\CourseDomain\CoachingWeek\Repository\CoachingWeekRepository;
use App\Src\CourseDomain\Course\Model\Course;

class MakeUpWeekDeleteAction
{
    private CoachingWeekRepository $coachingWeekRepository;

    public function __construct(CoachingWeekRepository $coachingWeekRepository)
    {
        $this->coachingWeekRepository = $coachingWeekRepository;
    }

    public function handle(Course $course)
    {
        $makeUpWeeks = $this->coachingWeekRepository->obtainByCourse($course);

        foreach ($makeUpWeeks as $makeUpWeek) {
            $makeUpWeek->delete();
        }
    }
}
