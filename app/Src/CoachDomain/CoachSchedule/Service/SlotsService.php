<?php

namespace App\Src\CoachDomain\CoachSchedule\Service;

use App\Src\CoachDomain\CoachSchedule\Model\CoachSchedule;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class SlotsService
{
    /**
     * Dados un coach y un rango de fechas (normalmente será el mismo día) y un rango de minutos, obtiene los rangos guardados en su schedule y
     * agrupa los consecutivos devolviedo un array del tipo:
            0 => array:3 [
                "date" => "2023-06-26"
                "start_time" => "08:00"
                "end_time" => "10:00"
            ],
            1 => array:3 [
                "date" => "2023-06-26"
                "start_time" => "10:30"
                "end_time" => "11:00"
            ]
     *
     * Otro ejemplo: si teneos de 09:00 a 09:15, de 09:15 a 09:30, de 09:30 a 09:45...nos devuelve uno de 09:00 a 09:45)
     */
    public function buildSlotsFromSchedule(User $coach, Carbon $startDate, Carbon $endDate, int $minutes = 15): array
    {

        $events = CoachSchedule::query()
            ->where('coach_id', $coach->id)
            ->whereBetween('day', [$startDate->toDateString(), $endDate->toDateString()])
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        $consecutiveSlots = [];
        $currentSlot = null;

        foreach ($events as $event) {

            $fecha = $event->day->toDateString();
            $startTime = strtotime($event->start_time);
            $endTime = strtotime($event->end_time);

            if ($currentSlot === null || $fecha !== $currentSlot['date'] || $startTime > strtotime($currentSlot['end_time']) + ($minutes * 60)) {
                // Iniciar un nuevo rango
                if ($currentSlot !== null) {
                    $consecutiveSlots[] = $currentSlot;
                }

                $currentSlot = [
                    'date' => $fecha,
                    'start_time' => date('H:i', $startTime),
                    'end_time' => date('H:i', $endTime),
                ];
            } else {
                // Actualizar el límite del rango actual
                $currentSlot['end_time'] = date('H:i', $endTime);
            }
        }

        // Agregar el último rango a la lista de rangos consecutivos
        if ($currentSlot !== null) {
            $consecutiveSlots[] = $currentSlot;
        }

        return $consecutiveSlots;
    }

    /*
       Dada una fecha y dos arrays de entrada con pares de horas del tipo:
       $starTimes  = [   0 => "00:00",     1 => "07:00",   2 => "10:30",   3 => "14:30"]
       $endTimes   = [   0 => "02:00",     1 => "08:30",   2 => "12:00",   3 => "15:00"]

       retorna una colección de clases Slot separados cada $minutes
    */
    public function generateSlots(SlotsUtc $slotsUtc, int $minutes = 15): Collection
    {
        $slots = collect();

        foreach ($slotsUtc->slots() as $dateSlot) {

            $period = $dateSlot->periodRange($minutes . ' minutes');

            foreach ($period as $start) {

                $end = $start->clone()->addMinutes($minutes)->subMinute()->endOfMinute();

                $interval = [
                    'start' => $start,
                    'end' => $end,
                ];

                $slot = DateSlot::fromIntervalWithStartAndEnd($interval);

                //echo "<br>".$slot->start()->toDateTimeString();
                $slots->push($slot);
            }

            //eliminamos el último slot
            $slots->pop();
        }

        return $slots;
    }

    /*
     * Elimina de SlotsOne slots que existan en $slotsTwo
     */
    public function removeDuplicateRanges(Collection $slotsOne, Collection $slotsTwo): Collection
    {
        $filteredRanges = collect();

        foreach ($slotsOne as $slotOne) {

            $isDuplicate = false;

            foreach ($slotsTwo as $slotTwo) {
                if ($slotOne->isStartEqual($slotTwo->start()) and $slotOne->isEndEqual($slotTwo->end())) {
                    $isDuplicate = true;
                    break;
                }
            }

            if (! $isDuplicate) {
                $filteredRanges->push($slotOne);
            }
        }

        return $filteredRanges;
    }

    private function show(Collection $slots)
    {
        echo '<br>-----------slots-------------<br>';
        $slots->map(function ($slot) {
            echo '<br>'.$slot->toPrint();
        });
    }

    private function showArray($array)
    {
        echo '<br>---------Array---------------<br>';
        foreach ($array as $item) {
            echo '<br>'.$item['start'].' # '.$item['end'];
        }
    }
}
