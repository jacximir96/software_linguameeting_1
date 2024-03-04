<?php

namespace App\Src\CoachDomain\CoachSchedule\Action;

use App\Src\CoachDomain\CoachSchedule\Action\Command\DeleteCommand;
use App\Src\CoachDomain\CoachSchedule\Repository\CoachScheduleRepository;
use App\Src\CoachDomain\CoachSchedule\Request\CoachScheduleRequest;
use App\Src\CoachDomain\CoachSchedule\Service\DateSlot;
use App\Src\UserDomain\User\Model\User;

class DeleteForSamedayWeekAction
{
    private CoachScheduleRepository $coachScheduleRepository;

    private DeleteCommand $deleteCoachSheduleCommand;

    public function __construct(CoachScheduleRepository $coachScheduleRepository, DeleteCommand $deleteCoachSheduleCommand)
    {

        $this->coachScheduleRepository = $coachScheduleRepository;
        $this->deleteCoachSheduleCommand = $deleteCoachSheduleCommand;
    }

    public function handle(CoachScheduleRequest $request, User $coach, DateSlot $slot)
    {

        foreach ($request->period() as $date) {

            if ($request->hasDayOfWeek($date->dayOfWeek)) {

                $customDateSlot = $slot->buildSameTimesWithOtherDate($date);

                $events = $this->coachScheduleRepository->obtainAvailabilityForCoachAndSlot($coach, $customDateSlot);

                foreach ($events as $event) {
                    if ($event->canBeDeleted()) {
                        $this->deleteCoachSheduleCommand->handle($event);
                    }
                }
            }
        }
    }
}
