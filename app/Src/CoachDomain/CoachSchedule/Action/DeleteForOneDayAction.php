<?php

namespace App\Src\CoachDomain\CoachSchedule\Action;

use App\Src\CoachDomain\CoachSchedule\Action\Command\DeleteCommand;
use App\Src\CoachDomain\CoachSchedule\Repository\CoachScheduleRepository;
use App\Src\CoachDomain\CoachSchedule\Service\DateSlot;
use App\Src\UserDomain\User\Model\User;

class DeleteForOneDayAction
{
    private CoachScheduleRepository $coachScheduleRepository;

    private DeleteCommand $deleteCoachSheduleCommand;

    public function __construct(CoachScheduleRepository $coachScheduleRepository, DeleteCommand $deleteCoachSheduleCommand)
    {

        $this->coachScheduleRepository = $coachScheduleRepository;
        $this->deleteCoachSheduleCommand = $deleteCoachSheduleCommand;
    }

    public function handle(User $coach, DateSlot $slot)
    {

        $availability = $this->coachScheduleRepository->obtainAvailabilityForCoachAndSlot($coach, $slot);

        foreach ($availability as $item) {
            if ($item->canBeDeleted()) {
                $this->deleteCoachSheduleCommand->handle($item);
            }
        }
    }
}
