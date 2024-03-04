<?php

namespace App\Src\CoachDomain\CoachSchedule\Action;

use App\Src\CoachDomain\CoachSchedule\Action\Command\CreateForOneDayCommand;
use App\Src\CoachDomain\CoachSchedule\Exception\ExistingAvailability;
use App\Src\CoachDomain\CoachSchedule\Repository\CoachScheduleRepository;
use App\Src\CoachDomain\CoachSchedule\Request\CoachScheduleRequest;
use App\Src\CoachDomain\CoachSchedule\Service\DateSlot;
use App\Src\CoachDomain\CoachSchedule\Service\SlotsUtc;
use App\Src\UserDomain\User\Model\User;


class CreateForOneDayAction
{
    private CreateForOneDayCommand $createAvailabiltyForOneDayCommand;

    private CoachScheduleRepository $coachScheduleRepository;

    public function __construct(CreateForOneDayCommand $createAvailabiltyForOneDayCommand, CoachScheduleRepository $coachScheduleRepository)
    {
        $this->createAvailabiltyForOneDayCommand = $createAvailabiltyForOneDayCommand;
        $this->coachScheduleRepository = $coachScheduleRepository;
    }

    public function handle(CoachScheduleRequest $request, User $coach, SlotsUtc $slotsUtc)
    {
        foreach ($slotsUtc->slots() as $slotUtc){
            $this->checkThatThereIsNoPriorAvailability($coach, $slotUtc);
        }

        $this->createAvailabiltyForOneDayCommand->handle($request, $coach, $slotsUtc);
    }

    private function checkThatThereIsNoPriorAvailability (User $coach, DateSlot $slotUtc){

        $availability = $this->coachScheduleRepository->obtainAvailabilityForCoachAndSlot($coach, $slotUtc);

        if ($availability->count()){
            throw new ExistingAvailability();
        }
    }
}
