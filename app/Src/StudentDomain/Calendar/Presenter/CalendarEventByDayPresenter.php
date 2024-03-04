<?php

namespace App\Src\StudentDomain\Calendar\Presenter;

use App\Src\CourseDomain\SessionDomain\Session\Repository\SessionRepository;
use App\Src\UserDomain\User\Model\User;
use Carbon\CarbonPeriod;

/*
 * Obtiene y construye los eventos para mostrar en el calendario de la disponiblidad de un coach
 *
 * Obtiene los registros de la tabla coach_schedule y los agrupa en rangos de horas.
 * AGRUPAR TODOS LOS RANGOS DE TIEMPO (los rangos van de 15 en 15 minutos. si teneos de 09:00 a 09:15, de 09:15 a 09:30, de 09:30 a 09:45...nos devuelve uno de 09:00 a 09:45
 */
class CalendarEventByDayPresenter
{
    use Slotable;

    /**
     * @var SessionRepository
     */
    private SessionRepository $sessionRepository;

    public function __construct (SessionRepository $sessionRepository){

        $this->sessionRepository = $sessionRepository;
    }

    public function handle(User $student, CarbonPeriod $period, CalendarSetup $calendarSetup): CalendarEventByDayResponse
    {

        $events = $this->sessionRepository->obtainSessionForStudentInPeriod($student, $period);

        $consecutivesSlots = [];
        $currentSlot = null;

        foreach ($events as $event) {

            $session = $event;

            $startDate = $event->startTime()->clone()->setTimezone($student->timezone->name);
            $endDate = $event->endTime()->clone()->setTimezone($student->timezone->name);

            $date = $startDate->toDateString();
            $horaInicio = strtotime($startDate->toTimeString());
            $horaFin = strtotime($endDate->toTimeString());

            if ($currentSlot === null || $date !== $currentSlot['date'] || $session->id != $currentSlot['session']['id']) {

                if ($currentSlot !== null) {
                    $consecutivesSlots[] = $currentSlot;
                }

                $currentSlot = $this->createSlot($session, $date, $horaInicio, $horaFin);
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

        //esto es susceptible de ser refactorizado a un solo lugar para equipararlo a lo que hay en CoachDomain/Calendar
        foreach ($consecutivesSlots as $slot) {

            $occupation = $slot['session']['occupation']['current_registered'].'/'.$slot['session']['occupation']['total_allowed'];
            $code = $slot['session']['session_type']['code'];
            $type = $slot['session']['flex'] ? 'Flex' : 'Week';

            $endTime = strtotime($slot['end_hour']);
            $endTime = date("H:i", strtotime('+1 minute', $endTime));

            if ($calendarSetup->isListDay()) {
                $title = "<span class='d-block'>".$occupation.' - '.$code.' - '.$type.' - '.$slot['reservedInfo']['course']['name'].'</span>';
            } else {
                $title = "<span class='d-block fw-bold'>".$slot['start_hour'].' - '.$endTime.'</span> <span style="position:absolute;top:0;right:2px">'.$occupation.' - '.$code.' - '.$type.'</span>'
                    ."<span class='d-block'>".$slot['reservedInfo']['course']['name'].'</span>'
                    ."<span class='d-block'>".$slot['reservedInfo']['university']['name'].'</span>';
            }

            $event = [
                'title' => $title,
                'start' => $slot['date'].'T'.$slot['start_hour'],
                'end' => $slot['date'].'T'.$slot['end_hour'],
                'allDay' => false,
                'textColor' => '#000000',
                'backgroundColor' => '#FFFFFF',
                'url' => route('get.student.session.calendar.show', $slot['session']['hashId']),
                'classNames' => ['open-modal'],
                'session' => $slot['session'],
                'extendedProps' => [
                    'modalTitle' => 'Show Session: '.$slot['date_carbon']->format('m/d/Y').' '.$slot['start_hour'].' - '.$endTime,
                    'reservedInfo' => $slot['reservedInfo'],
                ],
            ];

            $events[] = $event;
        }

        return new CalendarEventByDayResponse($events);
    }

    private function obtainTooltipText(CoachSchedule $event): string
    {

        if ($event->isReserved()) {
            return 'Course '.$event->course->name.' ('.$event->course->university->name.')';
        }

        return '';
    }
}
