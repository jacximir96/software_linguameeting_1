<?php

namespace App\Src\CoachDomain\Calendar\Presenter;

use App\Src\CoachDomain\CoachSchedule\Model\CoachSchedule;
use App\Src\CoachDomain\CoachSchedule\Repository\CoachScheduleRepository;
use App\Src\UserDomain\User\Model\User;
use Carbon\CarbonPeriod;

/*
 * Obtiene y construye los eventos para mostrar en el calendario de la disponiblidad de un coach
 *
 * Obtiene los registros de la tabla coach_schedule y los agrupa en rangos de horas.
 * AGRUPAR TODOS LOS RANGOS DE TIEMPO (los rangos van de 15 en 15 minutos. si teneos de 09:00 a 09:15, de 09:15 a 09:30, de 09:30 a 09:45...nos devuelve uno de 09:00 a 09:45
 */
class CalendarEventByWeekPresenter
{
    use Slotable;

    private CoachScheduleRepository $coachScheduleRepository;

    public function __construct(CoachScheduleRepository $coachScheduleRepository)
    {

        $this->coachScheduleRepository = $coachScheduleRepository;
    }

    public function handle(User $coach, CarbonPeriod $period, int $minutes = 15): CalendarEventByWeekResponse
    {

        $events = $this->coachScheduleRepository->obtainAvailabilityReserverdForCoachAndPeriod($coach, $period);

        $consecutivesSlots = [];
        $currentSlot = null;

        foreach ($events as $event) {

            $date = $event->day->toDateString();
            $horaInicio = strtotime($event->start_time);
            $horaFin = strtotime($event->end_time);

            $session = $event->session;
            if ($currentSlot === null || $date !== $currentSlot['date'] || $session->course_id != $currentSlot['course_id']) {

                if ($currentSlot !== null) {
                    $consecutivesSlots[] = $currentSlot;
                }

                $currentSlot = $this->createSlot($session, $date, $event, $horaInicio, $horaFin);
            } else {
                // Actualizar el límite del rango actual
                $currentSlot['end_hour'] = date('H:i', $horaFin);
            }
        }

        // Agregar el último rango a la lista de rangos consecutivos
        if ($currentSlot !== null) {
            $consecutivesSlots[] = $currentSlot;
        }

        $events = [];
        foreach ($consecutivesSlots as $slot) {

            $title = "<span class='d-block'>".$slot['start_hour'].' - '.$slot['end_hour'].'</span>'."<span class='d-block'>".$slot['reservedInfo']['course']['name'].'</span>';

            $event = [
                'title' => $title,
                'start' => $slot['date'].'T'.$slot['start_hour'],
                'end' => $slot['date'].'T'.$slot['end_hour'],
                'allDay' => false,
                'textColor' => '#000000',
                'backgroundColor' => $slot['reservedInfo']['course']['color'],
                'url' => route('get.coach.calendar.availability.session.show', $slot['session']['id']),
                'classNames' => ['open-modal'],
                'session' => $slot['session'],
                'extendedProps' => [
                    'modalTitle' => 'Show Session: '.$slot['date_carbon']->format('m/d/Y').' '.$slot['start_hour'].' - '.$slot['end_hour'],
                    'reservedInfo' => $slot['reservedInfo'],
                ],
            ];

            $events[] = $event;
        }

        return new CalendarEventByWeekResponse($events);
    }

    private function obtainTooltipText(CoachSchedule $event): string
    {

        if ($event->isReserved()) {
            return 'Course '.$event->course->name.' ('.$event->course->university->name.')';
        }

        return '';
    }
}
