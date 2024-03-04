<?php
namespace App\Src\CoachDomain\CoachSchedule\Presenter;

use App\Src\CoachDomain\CoachSchedule\Repository\CoachScheduleRepository;
use App\Src\CoachDomain\CoachSchedule\Service\SlotsUtc;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;


/*
 * Obtiene y construye los eventos para mostrar en el calendario de la disponiblidad de un coach
 *
 * Obtiene los registros de la tabla coach_schedule y los agrupa en rangos de horas.
 * AGRUPAR TODOS LOS RANGOS DE TIEMPO (los rangos van de 15 en 15 minutos. si tenemos de 09:00 a 09:15, de 09:15 a 09:30, de 09:30 a 09:45...nos devuelve uno de 09:00 a 09:45
 */
class CalendarEventByMonthPresenter
{
    private CoachScheduleRepository $coachScheduleRepository;

    public function __construct(CoachScheduleRepository $coachScheduleRepository)
    {
        $this->coachScheduleRepository = $coachScheduleRepository;
    }

    // Carbon $period: debe tener el timezone de destino
    public function handle(User $viewerUser, User $coach, SlotsUtc $slotsUtcCalendarRange, TimeZone $finalTimezone, int $minutes = 15): CalendarEventByMonthResponse
    {

        $period = $slotsUtcCalendarRange->slots()->first()->period();

        $events = $this->coachScheduleRepository->obtainAvailabilityForCoachAndPeriodInUtc($coach, $period);

        $consecutivesSlots = [];
        $currentSlot = null;

        foreach ($events as $event) {

            //Transformación de las fechas-horas del evento al timezone de destino.
            $startDate = Carbon::parse($event->day->toDateString().' '.$event->start_time)->setTimezone($finalTimezone->name);
            $endDate = Carbon::parse($event->day->toDateString().' '.$event->end_time)->setTimezone($finalTimezone->name);

            $date = $startDate->toDateString();

            $horaInicio = strtotime($startDate->toTimeString());
            $horaFin = strtotime($endDate->toTimeString());

            if ($currentSlot === null || $date !== $currentSlot['date'] || $horaInicio > strtotime($currentSlot['end_hour']) + ($minutes * 60)) {

                // Iniciar un nuevo rango
                if ($currentSlot !== null) {
                    $consecutivesSlots[] = $currentSlot;
                }

                $currentSlot = [
                    'date' => $date,
                    'start_hour' => date('H:i', $horaInicio),
                    'end_hour' => date('H:i', $horaFin),
                    'blocked_ses' => $event->blocked_ses,
                ];
            } else {
                // Actualizar el límite del rango actual
                $currentSlot['end_hour'] = date('H:i', $horaFin);
            }
        }

        // Agregar el último rango a la lista de rangos consecutivos
        if ($currentSlot !== null) {
            $consecutivesSlots[] = $currentSlot;
        }

        // crear un array con elementos con el formato de full calendar
        $events = [];
        foreach ($consecutivesSlots as $slot) {
            //slot => array:3 ["date" => "2023-06-26", "start_hour" => "00:00", "end_hour" => "01:00"]

            $startAsFinalTimezone = Carbon::parse($slot['date'].' '.$slot['start_hour'], $finalTimezone->name);
            $endAsFinalTimezone = Carbon::parse($slot['date'].' '.$slot['end_hour'], $finalTimezone->name);

            if ($slot['end_hour'] == '00:00'){
                $endAsFinalTimezone->addDay();
            }

            $startUTC = $startAsFinalTimezone->clone()->setTimezone('UTC');
            $endUTC = $endAsFinalTimezone->clone()->setTimezone('UTC');

            $event = [
                'title' => $startAsFinalTimezone->format('H:i').' - '.$endAsFinalTimezone->clone()->addMinute()->format('H:i'),
                'start' => $startAsFinalTimezone->toDateString().'T'.$startAsFinalTimezone->format('H:i'),
                'end' => $endAsFinalTimezone->toDateString().'T'.$endAsFinalTimezone->format('H:i'),
                'allDay' => false,
                'textColor' => '#000000',
                'classNames' => ['open-modal'],
                'extendedProps' => [
                    'modalTitle' => 'Edit Availability: '.toDate($startAsFinalTimezone).' at '.$startAsFinalTimezone->format('H:i').' - '.$endAsFinalTimezone->clone()->addMinute()->format('H:i'),
                    'blockedSes' => $slot['blocked_ses'],
                ],
            ];

            if ($viewerUser->isSame($coach)){
                $event['url'] = route('get.coach.schedule.availability.edit', [$coach->hashId(), $startUTC->toDateString(), $startUTC->format('H:i'), $endUTC->format('H:i')]);
            }

            $events[] = $event;
        }


        return new CalendarEventByMonthResponse($events);
    }
}
