<?php
namespace App\Src\ExperienceDomain\Experience\Presenter;

use App\Src\ExperienceDomain\Experience\Model\Experience;


class ExperienceItem
{

    private Experience $experience;

    private int $numStudents;

    public function __construct (Experience $experience, int $numStudents){
        $this->experience = $experience;
        $this->numStudents = $numStudents;
    }

    public function experience(): Experience
    {
        return $this->experience;
    }

    public function numStudents(): int
    {
        return $this->numStudents;
    }
}
