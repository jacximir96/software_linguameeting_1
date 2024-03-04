<?php

namespace App\Src\StudentRole\BookSession\Service\Availability;

use App\Src\CoachDomain\CoachSchedule\Model\CoachSchedule;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class CoachAvailability
{
    //construct
    private User $coach;

    private Filter $filter;

    //status
    private Collection $freeSlots;

    private Collection $consecutiveCoachSchedule;

    private ?CoachSchedule $lastCoachSchedule;

    public function __construct(User $coach, Filter $filter)
    {
        $this->coach = $coach;
        $this->filter = $filter;
        $this->freeSlots = collect();

        $this->initialize();
    }

    public function coach(): User
    {
        return $this->coach;
    }

    public function freeSlots(): Collection
    {
        return $this->freeSlots;
    }

    public function addCoachSchedule(CoachSchedule $coachSchedule)
    {

        if ($this->isOtherCourse($coachSchedule)){
            $this->initialize();
            return;
        }

        if (is_null($this->lastCoachSchedule)) {
            $this->lastCoachSchedule = $coachSchedule;
            $this->addConsecutiveCoachSchedule($coachSchedule);
        } else {

            if ($this->lastCoachSchedule->otherIsSuccesive($coachSchedule)) {

                $this->addConsecutiveCoachSchedule($coachSchedule);

                if ($this->hasSlotsFullSessionDuration()) {
                    $freeSlot = new FreeSlot($this->consecutiveCoachSchedule);
                    $this->freeSlots->push($freeSlot);

                    $this->initialize();
                }
            } else {
                $this->initialize();
            }
        }
    }

    private function initialize()
    {
        $this->consecutiveCoachSchedule = collect();
        $this->lastCoachSchedule = null;
    }

    private function addConsecutiveCoachSchedule(CoachSchedule $coachSchedule)
    {
        $this->consecutiveCoachSchedule->push($coachSchedule);
    }

    private function hasSlotsFullSessionDuration(): bool
    {

        $sumMinutes = 0;

        foreach ($this->consecutiveCoachSchedule as $coachSchedule) {

            $startTime = $coachSchedule->startTime()->clone();
            $endTime = $coachSchedule->endTime()->clone()->addSecond();

            $sumMinutes += $startTime->diffInMinutes($endTime);

            if ($sumMinutes >= $this->filter->sessionDuration()->get()) {
                return true;
            }
        }

        return false;
    }

    private function isOtherCourse(CoachSchedule $coachSchedule){

        if ($coachSchedule->session){

            $course = $coachSchedule->session->course;

            if ( ! $course->isSame($this->filter->course())){
                return true;
            }
        }

        return false;
    }
}
