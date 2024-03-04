<?php

namespace App\Src\CoachDomain\CoachSchedule\Action;

use App\Src\CoachDomain\CoachSchedule\Action\Command\CreateForOneDayCommand;
use App\Src\CoachDomain\CoachSchedule\Exception\ExistingAvailability;
use App\Src\CoachDomain\CoachSchedule\Repository\CoachScheduleRepository;
use App\Src\CoachDomain\CoachSchedule\Request\CoachScheduleRequest;
use App\Src\CoachDomain\CoachSchedule\Service\SlotsUtc;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;


class CreateForPeriodAction
{
    private CreateForOneDayCommand $createAvailabiltyForOneDayCommand;

    private CoachScheduleRepository $coachScheduleRepository;

    public function __construct(CreateForOneDayCommand $createAvailabiltyForOneDayCommand, CoachScheduleRepository $coachScheduleRepository)
    {
        $this->createAvailabiltyForOneDayCommand = $createAvailabiltyForOneDayCommand;
        $this->coachScheduleRepository = $coachScheduleRepository;
    }

    public function handle(CoachScheduleRequest $request, User $coach, TimeZone $timeZone)
    {

        foreach ($request->period() as $date) {

            $dateTimezone = Carbon::parse($date->toDateString(), $timeZone->name);
            $slotsUtc = SlotsUtc::convertSlotsRequestsToUtc($dateTimezone, $request->start_time, $request->end_time);

            $this->checkThatThereIsNoPriorAvailability($slotsUtc, $coach);

            $this->createAvailabiltyForOneDayCommand->handle($request, $coach, $slotsUtc);
        }
    }

    private function checkThatThereIsNoPriorAvailability(SlotsUtc $slotsUtc, User $coach): void
    {
        foreach ($slotsUtc->slots() as $slotUtc) {
            $availability = $this->coachScheduleRepository->obtainAvailabilityForCoachAndSlot($coach, $slotUtc);

            if ($availability->count()) {
                throw new ExistingAvailability();
            }
        }
    }
}
