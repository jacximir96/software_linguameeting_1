<?php
namespace App\Src\CourseDomain\SessionDomain\StudentReview\Service;

use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\NumericGrade;


class Grade
{
    private NumericGrade $participationGrade;

    private NumericGrade $preparedGrade;

    private NumericGrade $puntualityGrade;

    public function __construct (NumericGrade $participationGrade, NumericGrade $preparedGrade, NumericGrade $puntualityGrade){
        $this->participationGrade = $participationGrade;
        $this->preparedGrade = $preparedGrade;
        $this->puntualityGrade = $puntualityGrade;
    }

    public function participationGrade(): NumericGrade
    {
        return $this->participationGrade;
    }

    public function preparedGrade(): NumericGrade
    {
        return $this->preparedGrade;
    }

    public function puntualityGrade(): NumericGrade
    {
        return $this->puntualityGrade;
    }

    public function total ():NumericGrade{

        $total = $this->participationGrade->get() + $this->preparedGrade->get() + $this->puntualityGrade->get();

        return new NumericGrade($total);

    }
}
