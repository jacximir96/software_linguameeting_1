<?php
namespace App\Src\StudentDomain\Enrollment\Service;

use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use Illuminate\Support\Collection;


class SessionsWeeksBag
{
    private int $numTotalSessions;

    //las sessions son modelos de enrollmentSession

    private Collection $missedSessions;

    private Collection $missedWeeks;

    private Collection $todaySessions;

    private Collection $nextSessions;

    private Collection $nextWeeks;

    private Collection $completedSessions;


    public function __construct(int $numTotalSessions){

        $this->numTotalSessions = $numTotalSessions;

        $this->missedSessions = collect();
        $this->missedWeeks = collect();

        $this->todaySessions = collect();

        $this->nextSessions = collect();
        $this->nextWeeks = collect();

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

    public function missedSessions ():ItemWeekBag{
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
    public function addNextWeek (CoachingWeek $coachingWeek){
        $this->nextWeeks->push($coachingWeek);
    }

    public function addNextSession (EnrollmentSession $enrollmentSession){
        $this->nextSessions->push($enrollmentSession);
    }

    public function hasNext ():bool{
        return (bool)$this->nextWeeks->count() OR (bool)$this->nextSessions->count();
    }

    public function nextSessionsCount():int{
        return $this->nextWeeks->count() + $this->nextSessions->count();
    }

    public function nextSessions ():ItemWeekBag{
        return $this->buildItemBag($this->nextWeeks, $this->nextSessions);
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

    public function completedSessions():ItemWeekBag{

        $itemBag = new ItemWeekBag();

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


    private function buildItemBag (Collection $weeks, Collection $sessions):ItemWeekBag{

        $itemBag = new ItemWeekBag();

        foreach ($weeks as $nextWeek){
            $itemBag->addCoachingWeek($nextWeek);
        }

        foreach ($sessions as $nextSession){
            $itemBag->addSession($nextSession);
        }

        return $itemBag;
    }
}
