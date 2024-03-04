<?php
namespace App\Src\CourseDomain\Assignment\Service;

use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use Illuminate\Support\Collection;


class AssignmentCollection
{

    private Collection $assignments;

    public function __construct (){
        $this->assignments = collect();
    }

    public function get():Collection{
        return $this->assignments;
    }

    public function push (Assignment $assignment){
        $this->assignments->push($assignment);
    }

    public function getBySessionOrder (SessionOrder $sessionOrder):?Assignment{

        foreach ($this->assignments as $assignment){

            if ($assignment->isSessionOrder($sessionOrder)){
                return $assignment;
            }
        }

        return null;
    }
}
