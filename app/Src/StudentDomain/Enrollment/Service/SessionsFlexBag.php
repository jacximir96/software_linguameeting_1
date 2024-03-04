<?php
namespace App\Src\StudentDomain\Enrollment\Service;

use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Flex\Service\FlexSession;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\Shared\Presenter\Breadcrumb\Item;
use Illuminate\Support\Collection;


class SessionsFlexBag
{

    private int $numTotalSessions;

    //las sessions son modelos de enrollmentSession
    private Collection $missedSessions;

    private Collection $missedWeeks; //check aquí no tiene sentido esta colección

    private Collection $todaySessions;

    private Collection $nextSessions;

    private Collection $nextFlexSessions;

    private Collection $completedSessions;


    public function __construct(int $numTotalSessions){

        $this->numTotalSessions = $numTotalSessions;

        $this->missedSessions = collect();
        $this->missedWeeks = collect();

        $this->todaySessions = collect();

        $this->nextSessions = collect();
        $this->nextFlexSessions = collect();

        $this->completedSessions = collect();
    }

    public function addTotalSessionsByExtraSession (){
        $this->numTotalSessions++;
    }

    public function remainedPercentage():int{
        return 100-($this->missedPercentage()+$this->completedPercentage());
    }

    public function remainedSessionsCount():int{
        return $this->numTotalSessions - ($this->missedSessionsCount() + $this->completedSessionsCount());
    }

    //*********
    //missed
    //*********
    public function addMissedSession (EnrollmentSession $enrollmentSession){
        $this->missedSessions->push($enrollmentSession);
    }

    public function addMissedWeeks (CoachingWeek $coachingWeek){
        $this->missedWeeks->push($coachingWeek);
    }

    public function hasMissed ():bool{
        return (bool)$this->missedSessions->count() OR (bool)$this->missedWeeks->count();
    }

    public function missedSessionsCount():int{
        return $this->missedSessions->count() + $this->missedWeeks->count();
    }

    public function missedSessions ():ItemFlexBag{
        return $this->buildItemBag($this->missedWeeks, $this->missedSessions);
    }

    public function missedPercentage():int{

        if( ! $this->numTotalSessions){
            return 0;
        }

        return round(($this->missedSessionsCount() * 100) / $this->numTotalSessions);
    }

    //*********
    //today
    //*********
    public function addTodaySession (EnrollmentSession $enrollmentSession){
        $this->todaySessions->push($enrollmentSession);
    }

    public function hasTodaySessions ():bool{
        return (bool)$this->todaySessions->count();
    }

    public function todaySessions ():ItemWeekBag{
        $itemBag = new ItemWeekBag();

        foreach ($this->todaySessions as $todaySession){
            $itemBag->addSession($todaySession);
        }

        return $itemBag;
    }


    //*********
    //next
    //*********
    public function addNextFlexSession (FlexSession $flexSession){
        $this->nextFlexSessions->push($flexSession);
    }

    public function addNextSession (EnrollmentSession $enrollmentSession){
        $this->nextSessions->push($enrollmentSession);
    }

    public function hasNext ():bool{
        return (bool)$this->nextFlexSessions->count() OR (bool)$this->nextSessions->count();
    }

    public function nextSessionsCount():int{
        return $this->nextFlexSessions->count() + $this->nextSessions->count();
    }

    public function nextSessions ():ItemFlexBag{
        return $this->buildItemBag($this->nextFlexSessions, $this->nextSessions);
    }


    //*********
    //completed
    //*********
    public function addCompletedSession (EnrollmentSession $enrollmentSession){
        $this->completedSessions->push($enrollmentSession);
    }

    public function hasCompleted ():bool{
        return (bool)$this->completedSessions->count();
    }

    public function completedSessionsCount():int{
        return $this->completedSessions->count();
    }

    public function completedSessions():ItemFlexBag{

        $itemBag = new ItemFlexBag();

        foreach ($this->completedSessions as $session){
            $itemBag->addSession($session);
        }

        return $itemBag;
    }

    public function completedPercentage():int{

        if( ! $this->numTotalSessions){
            return 0;
        }

        return round(($this->completedSessions->count() * 100) / $this->numTotalSessions);
    }

    //

    private function buildItemBag (Collection $flexSessions, Collection $enrollmentSessions):ItemFlexBag{

        $itemBag = new ItemFlexBag();

        foreach ($flexSessions as $flexSession){
            $itemBag->addFlexSession($flexSession);
        }

        foreach ($enrollmentSessions as $nextSession){
            $itemBag->addSession($nextSession);
        }

        return $itemBag;
    }
}
