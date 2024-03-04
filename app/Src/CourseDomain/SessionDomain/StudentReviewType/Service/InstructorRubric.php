<?php
namespace App\Src\CourseDomain\SessionDomain\StudentReviewType\Service;

use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\ParticipationType;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\PreparedClassType;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\PunctualityType;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\StudentReviewType;
use Illuminate\Support\Collection;

class InstructorRubric
{

    private Collection $punctualityTypes;

    private Collection $preparedTypes;

    private Collection $participationTypes;

    public function __construct (Collection $punctualityTypes, Collection $preparedTypes, Collection $participationTypes){

        $this->punctualityTypes = $punctualityTypes;
        $this->preparedTypes = $preparedTypes;
        $this->participationTypes = $participationTypes;
    }

    public function punctualityTypes(): Collection
    {
        return $this->punctualityTypes;
    }

    public function preparedTypes(): Collection
    {
        return $this->preparedTypes;
    }

    public function participationTypes(): Collection
    {
        return $this->participationTypes;
    }

    public function generalDescription (string $type, string $level):string{

        $type = $this->obtainType($type, $level);

        return $type->description;

    }

    public function instructorDescription (string $type, string $level):string{

        $type = $this->obtainType($type, $level);

        return $type->description_instructor;

    }

    private function obtainType (string $type, string $level):StudentReviewType{

        $idKey = 'linguameeting.session.rubric.levels.'.$level .'.id';
        $id = config($idKey);

        switch ($type){

            case PunctualityType::DESCRIPCION:
                return $this->punctualityTypes->get($id);

            case PreparedClassType::DESCRIPCION:
                return $this->preparedTypes->get($id);

            case ParticipationType::DESCRIPCION:
                return $this->participationTypes->get($id);
        }
    }
}
