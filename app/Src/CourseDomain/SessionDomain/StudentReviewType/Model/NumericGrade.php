<?php
namespace App\Src\CourseDomain\SessionDomain\StudentReviewType\Model;


class NumericGrade
{

    private int $value;

    public function __construct(int $value){

        $this->value = $value;
    }

    public function get(): int
    {
        return $this->value;
    }
}
