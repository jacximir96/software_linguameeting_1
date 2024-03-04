<?php

namespace App\Src\CoachDomain\CoachSchedule\Action\Command;

use App\Src\CoachDomain\CoachSchedule\Model\CoachSchedule;
use App\Src\CoachDomain\CoachSchedule\Repository\CoachScheduleRepository;
use App\Src\CoachDomain\CoachSchedule\Request\CoachScheduleRequest;
use App\Src\CoachDomain\CoachSchedule\Service\SlotsUtc;
use App\Src\CoachDomain\CoachSchedule\Service\SlotsService;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class CreateForOneDayCommand
{
    private SlotsService $slotsService;

    private CoachScheduleRepository $scheduleRepository;

    public function __construct(SlotsService $slotsService, CoachScheduleRepository $scheduleRepository)
    {
        $this->slotsService = $slotsService;
        $this->scheduleRepository = $scheduleRepository;
    }

    //request continene los rangos de las horas seleccionadas
    //date contiene el timezone origen (el del coach)
    public function handle(CoachScheduleRequest $request, User $coach, SlotsUtc $finalSlotsUtc)
    {

        $newSlotsFromUserRequestInUtc = $this->slotsService->generateSlots($finalSlotsUtc);

        $newSlotsFromUserRequestInUtc = $this->slotsService->generateSlots($finalSlotsUtc);

        $slotsExistingPrevious = $this->scheduleRepository->obtainSlotsTimeExisting($coach, $finalSlotsUtc);

        $newsSlotsNotExistingPrevious = $this->slotsService->removeDuplicateRanges($newSlotsFromUserRequestInUtc, $slotsExistingPrevious);

        /*
        $this->show($newSlotsFromUserRequestInUtc);
        $this->show($slotsExistingPrevious);
        $this->show($newsSlotsNotExistingPrevious);
        echo "<br>--###--<br>";
        */

        foreach ($newsSlotsNotExistingPrevious as $slot) {


            $schedule = new CoachSchedule();
            $schedule->coach_id = $coach->id;
            $schedule->day = $slot->start();
            $schedule->start_time = $slot->start()->toTimeString();
            $schedule->end_time = $slot->end()->toTimeString();
            $schedule->day_of_week = $slot->start()->dayOfWeek;

            if ($request->applyHoursOff()) {
                $schedule->blocked_ses = true;
            }

            $schedule->save();
        }
    }

    private function show(Collection $slots)
    {
        echo '<br>----------slots--------------<br>';
        $slots->map(function ($slot) {
            echo '<br>'.$slot->toPrint();
        });
    }
}
