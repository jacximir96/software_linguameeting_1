<?php
namespace App\Src\CoachDomain\CoachSchedule\Action;

use App\Src\CoachDomain\CoachSchedule\Action\Command\CreateForOneDayCommand;
use App\Src\CoachDomain\CoachSchedule\Action\Command\DeleteSlotCommand;
use App\Src\CoachDomain\CoachSchedule\Request\CoachScheduleRequest;
use App\Src\CoachDomain\CoachSchedule\Service\DateSlot;
use App\Src\CoachDomain\CoachSchedule\Service\SlotsUtc;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


class UpdateForSameDayWeekAction
{
    private CreateForOneDayCommand $createAvailabiltyForOneDayCommand;

    private DeleteSlotCommand $deleteSlotCommand;

    public function __construct(CreateForOneDayCommand $createAvailabiltyForOneDayCommand, DeleteSlotCommand $deleteSlotCommand)
    {
        $this->createAvailabiltyForOneDayCommand = $createAvailabiltyForOneDayCommand;
        $this->deleteSlotCommand = $deleteSlotCommand;
    }

    public function handle(CoachScheduleRequest $request, User $coach, CarbonPeriod $period, DateSlot $originalSlot, SlotsUtc $finalSlots)
    {

        foreach ($period as $date) {

            if ($request->hasDayOfWeek($date->dayOfWeek)) {

                $dateSlotToRemove = $originalSlot->buildSameTimesWithOtherDate($date);
                $this->deleteSlotCommand->handle($coach, $dateSlotToRemove);

                //vamos construyendo los slots que queremos con cada uno de los días del período.
                $finalSlotsWithNewDate = collect();
                foreach ($finalSlots->slots() as $dateSlot){
                    $slotToCreate = $dateSlot->buildSameTimesWithOtherDate($date);
                    $finalSlotsWithNewDate->push($slotToCreate);
                }

                $finalSlotsCreate = SlotsUtc::buildWithDateSlotsCollection($finalSlotsWithNewDate);

                $this->createAvailabiltyForOneDayCommand->handle($request, $coach, $finalSlotsCreate);
            }
        }
    }
}
