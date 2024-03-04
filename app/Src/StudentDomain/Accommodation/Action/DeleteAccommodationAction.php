<?php
namespace App\Src\StudentDomain\Accommodation\Action;

use App\Src\StudentDomain\Enrollment\Model\Enrollment;


class DeleteAccommodationAction
{

    public function handle(Enrollment $enrollment):Enrollment{

        $accommodation = $enrollment->accommodation;

        if ($accommodation){
            $accommodation->delete();
        }

        return $enrollment;
    }
}
