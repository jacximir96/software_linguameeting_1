<?php

namespace App\Src\StudentDomain\Student\Presenter;

use App\Src\ActivityLog\Repository\ActivityRepository;
use App\Src\ActivityLog\Repository\StudentActivityRepository;
use App\Src\StudentDomain\Student\Repository\StudentRepository;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;


class ShowStudentPresenter
{
    private User $student;

    private StudentRepository $studentRepository;

    private StudentActivityRepository $studentActivityRepository;

    public function __construct(StudentRepository $studentRepository, StudentActivityRepository $studentActivityRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->studentActivityRepository = $studentActivityRepository;
    }

    public function handle(User $student): ShowStudentResponse
    {

        $student->load($this->studentRepository->relations());

        $this->initialize($student);

        $activity = $this->obtainActivity();

        return new ShowStudentResponse($student, $activity);
    }

    private function initialize(User $student)
    {
        $this->student = $student;
    }

    private function obtainActivity(int $perPage = 5): LengthAwarePaginator
    {
        return $this->studentActivityRepository->obtainActivity($this->student, $perPage);
    }
}
