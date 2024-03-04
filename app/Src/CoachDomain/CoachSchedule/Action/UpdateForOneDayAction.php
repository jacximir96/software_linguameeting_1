<?php

namespace App\Src\CoachDomain\CoachSchedule\Action;

use App\Src\CoachDomain\CoachSchedule\Action\Command\CreateForOneDayCommand;
use App\Src\CoachDomain\CoachSchedule\Action\Command\DeleteCommand;
use App\Src\CoachDomain\CoachSchedule\Repository\CoachScheduleRepository;
use App\Src\CoachDomain\CoachSchedule\Request\CoachScheduleRequest;
use App\Src\CoachDomain\CoachSchedule\Service\DateSlot;
use App\Src\CoachDomain\CoachSchedule\Service\SlotsUtc;
use App\Src\UserDomain\User\Model\User;

class UpdateForOneDayAction
{
    private CoachScheduleRepository $scheduleRepository;

    private DeleteCommand $deleteCoachSheduleCommand;

    private CreateForOneDayCommand $createAvailabiltyForOneDayCommand;

    public function __construct(CoachScheduleRepository $scheduleRepository,
        DeleteCommand $deleteCoachSheduleCommand,
        CreateForOneDayCommand $createAvailabiltyForOneDayCommand)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->deleteCoachSheduleCommand = $deleteCoachSheduleCommand;
        $this->createAvailabiltyForOneDayCommand = $createAvailabiltyForOneDayCommand;
    }


    public function handle(CoachScheduleRequest $request, User $coach, DateSlot $originalSlot, SlotsUtc $finalSlots)
    {
        $this->deleteEvents($coach, $originalSlot);

        $this->createAvailabiltyForOneDayCommand->handle($request, $coach, $finalSlots);
    }

    private function deleteEvents(User $coach, DateSlot $slot)
    {

        $events = $this->scheduleRepository->obtainAvailabilityForCoachAndSlot($coach, $slot);

        foreach ($events as $event) {
            if ($event->canBeDeleted()) {
                $this->deleteCoachSheduleCommand->handle($event);
            }
        }
    }
}
