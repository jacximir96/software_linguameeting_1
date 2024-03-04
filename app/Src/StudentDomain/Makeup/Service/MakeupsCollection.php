<?php
namespace App\Src\StudentDomain\Makeup\Service;

use App\Src\StudentDomain\Makeup\Model\MakeupNumber;
use Illuminate\Support\Collection;

/**
 * Colección de makeups
 * Class EnrollmentMakeup
 * @package App\Src\StudentDomain\Makeup\Service
 */
class MakeupsCollection
{

    private Collection $makeups;

    public function get():Collection{
        return $this->makeups;
    }

    public function __construct (Collection $makeups){

        $this->makeups = $makeups;
    }

    public function countComplimentary ():MakeupNumber{

        $num = 0;

        foreach ($this->makeups as $makeup){

            if ( ! $makeup->hasBeenUsed()){
                $num++;
            }
        }

        return new MakeupNumber($num);
    }

    public function countPurchased ():MakeupNumber{

        $num = 0;

        foreach ($this->makeups as $makeup){
            if ( ! $makeup->isFree() ){
                $num++;
            }
        }

        return new MakeupNumber($num);
    }


    public function countAvailableToUse ():MakeupNumber{

        $num = 0;

        foreach ($this->makeups as $makeup){

            if ( ! $makeup->hasBeenUsed()){
                $num++;
            }
        }

        return new MakeupNumber($num);
    }
}
