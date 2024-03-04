<?php

namespace App\Src\CoachDomain\SemesterFinished\Action;

use App\Src\CoachDomain\SemesterFinished\Model\SemesterFinished;
use App\Src\CoachDomain\SemesterFinished\Repository\SemesterFinishedRepository;
use App\Src\UserDomain\User\Model\User;

class ChangeSemesterFinishedAction
{
    private SemesterFinishedRepository $semesterFinishedRepository;

    public function __construct(SemesterFinishedRepository $semesterFinishedRepository)
    {

        $this->semesterFinishedRepository = $semesterFinishedRepository;
    }

    public function handle(User $coach, int $semesterNumber, bool $checked): SemesterFinished
    {

        $this->checkSemesterNumber($semesterNumber);

        $semester = $this->semesterFinishedRepository->findByCoach($coach);
        $field = 'semester_'.$semesterNumber;

        if ($semester) {
            $semester->$field = $checked;
            $semester->save();

            return $semester;
        }

        $semester = new SemesterFinished();
        $semester->$field = $checked;
        $semester->save();

        return $semester;
    }

    private function checkSemesterNumber(int $semesterNumber)
    {

        if ($semesterNumber == 1) {
            return true;
        }

        if ($semesterNumber == 2) {
            return true;
        }

        throw new \InvalidArgumentException(sprintf('Semester Number %s is invalid', $semesterNumber));
    }
}
