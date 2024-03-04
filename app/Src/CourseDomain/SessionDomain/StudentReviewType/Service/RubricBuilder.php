<?php
namespace App\Src\CourseDomain\SessionDomain\StudentReviewType\Service;


use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\ParticipationType;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\PreparedClassType;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\PunctualityType;

class RubricBuilder
{

    public function buildForInstructor ():InstructorRubric{

        $punctuality = PunctualityType::orderBy('id')->get()->keyBy('id');
        $prepared = PreparedClassType::orderBy('id')->get()->keyBy('id');
        $participation = ParticipationType::orderBy('id')->get()->keyBy('id');


        return new InstructorRubric($punctuality, $prepared, $participation);
    }
}
