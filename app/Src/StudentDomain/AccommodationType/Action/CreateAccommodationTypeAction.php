<?php

namespace App\Src\StudentDomain\AccommodationType\Action;

use App\Src\StudentDomain\AccommodationType\Model\AccommodationType;
use App\Src\StudentDomain\AccommodationType\Request\AccommodationTypeRequest;

class CreateAccommodationTypeAction
{
    public function handle(AccommodationTypeRequest $request): AccommodationType
    {

        $accommodationType = new AccommodationType();
        $accommodationType->description = $request->description;
        $accommodationType->individual_session = $request->individual_session ?? false;
        $accommodationType->save();

        return $accommodationType;
    }
}
