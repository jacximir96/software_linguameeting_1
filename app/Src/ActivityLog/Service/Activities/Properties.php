<?php
namespace App\Src\ActivityLog\Service\Activities;


use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use Illuminate\Support\Collection;


/*
 * Wrapper de las propiedades de un registro de actividad
 */
class Properties
{

    private Collection $properties; //array de propiedades

    public function __construct (Collection $properties){

        $this->properties = $properties;
    }

    public function get():Collection{
        return $this->properties;
    }

    public function getProperty (string $searchedKey):array{

        foreach ($this->properties as $key => $property){

            if ($key == $searchedKey){
                return $property;
            }
        }

        throw new \InvalidArgumentException(sprintf('Field %s not found', $key));

    }

    public function obtainEnrollmentSession ():EnrollmentSession{

        $property = $this->getProperty('enrollment_session');

        return EnrollmentSessionRepository::findTrashed($property['id']);
    }
}
