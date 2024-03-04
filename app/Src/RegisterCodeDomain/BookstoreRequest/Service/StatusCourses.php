<?php

namespace App\Src\RegisterCodeDomain\BookstoreRequest\Service;

use App\Src\CourseDomain\Course\Service\Status\StatusLingro;

class StatusCourses
{
    private StatusLingro $statusLingro;

    private int $numActiveCourses;

    public function __construct(StatusLingro $statusLingro, int $numActiveCourses)
    {
        $this->statusLingro = $statusLingro;
        $this->numActiveCourses = $numActiveCourses;
    }

    public function statusLingro(): StatusLingro
    {
        return $this->statusLingro;
    }

    public function numActiveCourses(): int
    {
        return $this->numActiveCourses;
    }
}
