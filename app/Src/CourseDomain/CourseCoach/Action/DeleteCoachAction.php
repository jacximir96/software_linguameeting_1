<?php

namespace App\Src\CourseDomain\CourseCoach\Action;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\CourseCoach\Repository\CourseCoachRepository;
use App\Src\UserDomain\User\Model\User;

class DeleteCoachAction
{
    private CourseCoachRepository $courseCoachRepository;

    public function __construct(CourseCoachRepository $courseCoachRepository)
    {

        $this->courseCoachRepository = $courseCoachRepository;
    }

    public function handle(Course $course, User $coach)
    {

        $courseCoach = $this->courseCoachRepository->obtainByCourseAndCoachOrNull($course, $coach);

        if ($courseCoach) {
            $courseCoach->delete();
        }
    }
}
