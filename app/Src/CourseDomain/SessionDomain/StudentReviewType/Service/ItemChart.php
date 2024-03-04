<?php
namespace App\Src\CourseDomain\SessionDomain\StudentReviewType\Service;


class ItemChart
{

    private int $numStudents;

    private int $grade;

    public function __construct (int $numStudents, int $grade){

        $this->numStudents = $numStudents;
        $this->grade = $grade;
    }

    public function numStudents(): int
    {
        return $this->numStudents;
    }

    public function grade(): int
    {
        return $this->grade;
    }
}
