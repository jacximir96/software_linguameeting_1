<?php

namespace App\Src\CourseDomain\DenyAccess\Service;

use App\Src\CourseDomain\Course\Model\Course;
use Illuminate\Support\Collection;

class CheckerDenyAccess
{
    private Collection $denyAccess;

    public function __construct(Collection $denyAccess)
    {

        $this->denyAccess = $denyAccess;
    }

    public function hasDenyAccessToCourse(Course $course): bool
    {

        foreach ($this->denyAccess as $denyAccess) {
            if ($denyAccess->isSameCourse($course)) {
                return true;
            }
        }

        return false;

    }

    public function hasAllowedAccessToCourse(Course $course): bool
    {

        foreach ($this->denyAccess as $denyAccess) {
            if ($denyAccess->isSameCourse($course)) {
                return false;
            }
        }

        return true;
    }
}
