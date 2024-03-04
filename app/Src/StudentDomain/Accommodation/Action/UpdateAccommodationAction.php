<?php
namespace App\Src\StudentDomain\Accommodation\Action;

use App\Src\StudentDomain\Accommodation\Model\Accommodation;
use App\Src\StudentDomain\Accommodation\Request\AccommodationRequest;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;


class UpdateAccommodationAction
{

    public function handle(AccommodationRequest $request, Enrollment $enrollment):Accommodation{

        $accommodation = $enrollment->accommodation;

        if (is_null($accommodation)){

            $accommodation = new Accommodation();
            $accommodation->enrollment_id = $enrollment->id;
        }

        $accommodation->accommodation_type_id = $request->accommodation_type_id;
        $accommodation->description = $request->description ?? '';

        $accommodation->save();

        return $accommodation;
    }
}
