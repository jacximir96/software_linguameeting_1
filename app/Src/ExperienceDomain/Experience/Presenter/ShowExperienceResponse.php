<?php
namespace App\Src\ExperienceDomain\Experience\Presenter;

use App\Src\ExperienceDomain\Experience\Presenter\StudentsList;


class ShowExperienceResponse
{

    private StudentsList $studentsList;

    public function __construct(StudentsList $studentsList){
        $this->studentsList = $studentsList;
    }


    public function studentsList(): StudentsList
    {
        return $this->studentsList;
    }
}
