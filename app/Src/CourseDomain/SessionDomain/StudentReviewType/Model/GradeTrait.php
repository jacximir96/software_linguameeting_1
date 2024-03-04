<?php
namespace App\Src\CourseDomain\SessionDomain\StudentReviewType\Model;


trait GradeTrait
{

    public function grade ():NumericGrade{

        $best = 3;
        $medium = 2;
        $low = 1;

        if ($this instanceof ParticipationType){
            //la participación lleva +1 punto para que así pueda cuadrar con que los alumnos saquen un 10.
            $best++;
            $medium++;
            $low++;
        }

        switch ($this->id){

            case 1: return new NumericGrade($best);
            case 2: return new NumericGrade($medium);
            case 3: return new NumericGrade($low);
            case 4: return new NumericGrade(0);
        }

        return new NumericGrade(0);
    }
}
