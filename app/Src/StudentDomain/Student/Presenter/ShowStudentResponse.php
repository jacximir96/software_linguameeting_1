<?php

namespace App\Src\StudentDomain\Student\Presenter;

use App\Src\UserDomain\User\Model\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class ShowStudentResponse
{
    private User $student;

    private LengthAwarePaginator $activity;

    public function __construct(User $student, LengthAwarePaginator $activity)
    {

        $this->student = $student;
        $this->activity = $activity;

    }

    public function student(): User
    {
        return $this->student;
    }

    public function activity(): LengthAwarePaginator
    {
        return $this->activity;
    }
}
