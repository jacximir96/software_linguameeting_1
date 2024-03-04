<?php

namespace App\Src\CoachDomain\CoachSchedule\Action\Command;

use App\Src\CoachDomain\CoachSchedule\Repository\CoachScheduleRepository;
use App\Src\CoachDomain\CoachSchedule\Service\DateSlot;
use App\Src\UserDomain\User\Model\User;

class DeleteSlotCommand
{
    private CoachScheduleRepository $coachScheduleRepository;

    private DeleteCommand $deleteCommand;

    public function __construct(CoachScheduleRepository $coachScheduleRepository, DeleteCommand $deleteCommand)
    {

        $this->coachScheduleRepository = $coachScheduleRepository;
        $this->deleteCommand = $deleteCommand;
    }

    public function handle(User $coach, DateSlot $slot)
    {

        $events = $this->coachScheduleRepository->obtainAvailabilityForCoachAndSlot($coach, $slot);

        foreach ($events as $event) {
            if ($event->canBeDeleted()) {
                $this->deleteCommand->handle($event);
            }
        }
    }
}
