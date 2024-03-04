<?php
namespace App\Src\StudentDomain\Makeup\Service;

use App\Src\CourseDomain\Course\Service\CourseMakeup;
use App\Src\StudentDomain\Makeup\Model\MakeupNumber;


//instanciarse a través de MakeupSearcher
class MakeupAvailability
{

    private MakeupsCollection $makeupsCollection;

    private CourseMakeup $courseMakeup;

    private int $missedSessionsWithoutMakeupNum;

    public function __construct (MakeupsCollection $makeupsCollection, CourseMakeup $courseMakeup, int $missedSessionsWithoutMakeupNum){

        $this->makeupsCollection = $makeupsCollection;
        $this->courseMakeup = $courseMakeup;
        $this->missedSessionsWithoutMakeupNum = $missedSessionsWithoutMakeupNum;
    }

    public function makeupsCollection ():MakeupsCollection{
        return $this->makeupsCollection;
    }

    public function courseMakeup ():CourseMakeup{
        return $this->courseMakeup;
    }

    public function missedSessionsWithoutMakeupNum ():int{
        return $this->missedSessionsWithoutMakeupNum;
    }

    public function isNeedMoreMakeups ():bool{
        return $this->makeupsCollection->countAvailableToUse()->get() < $this->missedSessionsWithoutMakeupNum;
    }

    public function numMaxAvailableForPurchase():MakeupNumber{

        if ( ! $this->isNeedMoreMakeups()){
            return new MakeupNumber(0);
        }

        $numMaxAvailableForPurchaseConfigInCourse = $this->courseMakeup->numberMakeupsForPurchase();

        $purchased = $this->makeupsCollection->countPurchased();

        //totalAvailable = máximas que puede comprar menos las compradas
        $totalAvailable = $numMaxAvailableForPurchaseConfigInCourse->get() - $purchased->get();

        if ($totalAvailable < 0){
            $totalAvailable = 0;
        }

        if ($this->missedSessionsWithoutMakeupNum <= $totalAvailable){
            return new MakeupNumber($this->missedSessionsWithoutMakeupNum);
        }

        return new MakeupNumber($totalAvailable);
    }

    public function numMaxAvailableForFree ():MakeupNumber{

        if ( ! $this->isNeedMoreMakeups()){
            return new MakeupNumber(0);
        }

        $count = 0;

        foreach ($this->makeupsCollection->get() as $makeup){

            if ( !$makeup->hasBeenUsed() AND $makeup->isFree()){
                $count++;
            }
        }

        return new MakeupNumber($count);

    }

    public function hasMakeupAvailable():bool{

        return (bool)$this->makeupsCollection->countAvailableToUse()->get();
    }
}
