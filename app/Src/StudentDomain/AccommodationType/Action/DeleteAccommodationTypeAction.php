<?php

namespace App\Src\StudentDomain\AccommodationType\Action;

use App\Src\StudentDomain\AccommodationType\Model\AccommodationType;

class DeleteAccommodationTypeAction
{
    public function handle(AccommodationType $accommodationType): AccommodationType
    {

        $accommodationType->delete();

        return $accommodationType;

    }
}
