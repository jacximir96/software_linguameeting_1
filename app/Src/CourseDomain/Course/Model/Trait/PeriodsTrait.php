<?php
namespace App\Src\CourseDomain\Course\Model\Trait;

use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Flex\Service\FlexSession;
use App\Src\CourseDomain\Flex\Service\FlexSessions;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;


trait PeriodsTrait
{
    public function coachingWeeksOrdered(): Collection
    {
        return $this->coachingWeek->sortBy(function ($coachingWeek) {
            if ($coachingWeek->isMakeup()) {
                return 999;
            }

            return $coachingWeek->session_order;
        });
    }

    public function coachingWeeksSortedByDate(bool $withMakeup = true): Collection
    {
        return $this->coachingWeek->sortBy(function ($coachingWeek) {
            return $coachingWeek->start_date->toDateString();
        })->filter(function ($coachingWeek) use ($withMakeup){

            if ($withMakeup){
                return $coachingWeek;
            }
            else{
                if ( ! $coachingWeek->isMakeup()){
                    return $coachingWeek;
                }
            }
        });
    }

    public function coachingWeeksOrderedWithoutMakeUps(): Collection
    {
        return $this->coachingWeek->filter(function ($coachingWeek) {
            return ! $coachingWeek->isMakeup();
        })->sortBy(function ($coachingWeek) {
            return $coachingWeek->session_order;
        });
    }

    public function obtainCoachingWeekBySessionOrder(SessionOrder $sessionOrder): ?CoachingWeek
    {
        foreach ($this->coachingWeek as $coachingWeek){
            $sessionOrderWeek = $coachingWeek->sessionOrderObject();

            if ($sessionOrderWeek->isSame($sessionOrder)){
                return $coachingWeek;
            }
        }

        return null;
    }

    public function obtainCoachingWeekWithoutMakeUpGreatherThanSession(SessionOrder $sessionOrder): Collection
    {
        $coachingWeeks = $this->coachingWeeksOrdered();

        return $coachingWeeks->filter(function ($coachingWeek) use ($sessionOrder){

            if ( ! $coachingWeek->isMakeup()){
                if ($coachingWeek->sessionOrderObject()->get() > $sessionOrder->get()){
                    return $coachingWeek;
                }
            }
        });
    }

    public function obtainCoachingWeekFromToday (): ?CoachingWeek{

        foreach ($this->coachingWeeksOrderedWithoutMakeUps() as $coachingWeek){

            if ($coachingWeek->containsToday()){
                return $coachingWeek;
            }
        }

        return null;
    }

    public function obtainCoachingWeekFromDate (Carbon $date): ?CoachingWeek{

        foreach ($this->coachingWeeksOrdered() as $coachingWeek){

            if ($coachingWeek->containsDate($date)){
                return $coachingWeek;
            }
        }

        return null;
    }

    public function firstDate ():Carbon{

        if ($this->isFlex()){
            return $this->period()->getStartDate();
        }

        if ($this->hashasCoachingWeek){
            return $this->coachingWeeksSortedByDate(false)->first()->period()->getStartDate();
        }

        return $this->start_date;
    }

    public function lastDate ():Carbon{

        if ($this->isFlex()){
            return $this->period()->getEndDate();
        }

        if ($this->hashasCoachingWeek){
            return $this->coachingWeeksSortedByDate(false)->last()->period()->getEndDate();
        }

        return $this->end_date;
    }

    public function hasAlreadyStarted(): bool
    {
        return $this->start_date->startOfDay()->isPast();
    }

    public function hasCoachingWeek(): bool
    {
        return (bool) $this->coachingWeek->count();
    }

    public function obtainFlexSessions(): FlexSessions
    {

        $sessionsFlex = new FlexSessions();

        $numberOfSessions = $this->conversationPackage->number_session;

        for ($i = 1; $i <= $numberOfSessions; $i++) {

            $sessionFlex = new FlexSession($i);

            $sessionsFlex->addSession($sessionFlex);
        }

        return $sessionsFlex;
    }

    public function period(): CarbonPeriod
    {
        return new CarbonPeriod($this->start_date->startOfDay(), $this->end_date->endOfDay());
    }
}
