<?php

namespace App\Src\CourseDomain\DenyAccess\Action;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\DenyAccess\Model\DenyAccess;
use App\Src\CourseDomain\DenyAccess\Repository\DenyAccessRepository;
use App\Src\UserDomain\User\Model\User;

class ChangeAccessAction
{
    private DenyAccessRepository $denyAccessRepository;

    public function __construct(DenyAccessRepository $denyAccessRepository)
    {

        $this->denyAccessRepository = $denyAccessRepository;
    }

    public function handle(Course $course, User $user): DenyAccess
    {

        $deny = $this->denyAccessRepository->obtainByCourseAndUser($course, $user);

        if ($deny) {
            $deny->delete();

            return $deny;
        }

        $deny = new DenyAccess();
        $deny->course_id = $course->id;
        $deny->user_id = $user->id;
        $deny->save();

        return $deny;
    }
}
