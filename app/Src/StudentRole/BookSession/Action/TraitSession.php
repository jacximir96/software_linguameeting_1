<?php
namespace App\Src\StudentRole\BookSession\Action;

use App\Src\CoachDomain\CoachSchedule\Model\CoachSchedule;
use App\Src\StudentRole\BookSession\Service\Availability\TimeSlot;


trait TraitSession
{

    //de la opción seleccionada por el alumno, vemos si ya existe una sesión o hay que crear otra
    protected function configSelectedSession()
    {
        if ($this->isNeedToCreateNewSession()) {

            $this->createSession();

            $this->attachSessionToCoachSchedule();
        }
        else{
            $this->obtainSession();
        }
    }

    //es necesario cuando la disponibilidad seleccionada del coach no tiene asociada ninguna sesión
    protected function isNeedToCreateNewSession(): bool
    {
        $coachSchedulesIds = collect($this->request->coach_schedule_id);

        $this->coachSchedule = CoachSchedule::find($coachSchedulesIds->first());

        return is_null($this->coachSchedule->session);
    }

    //si la disponibilidad asociada tiene sesión...es la que obtenemos para asociarla al estudiante
    protected function obtainSession()
    {

        $coachSchedulesIds = collect($this->request->coach_schedule_id);

        $this->coachSchedule = CoachSchedule::find($coachSchedulesIds->first());

        $this->session = $this->coachSchedule->session;

    }

    protected function createSession()
    {
        $timeSlot = $this->obtainTimeForNewSession();

        $this->session = $this->createSessionCommand->handle($this->enrollment->course(), $this->coachSchedule->coach, $this->coachSchedule, $timeSlot);

    }

    protected function obtainTimeForNewSession(): TimeSlot
    {

        $coachSchedules = $this->coachScheduleRepository->obtainCoachSchedulesByIds($this->request->coach_schedule_id);

        return new TimeSlot($coachSchedules->first()->startAsTime(), $coachSchedules->last()->endAsTime());
    }

    //asociamos la sesión creada con la disponiblidad del coach, así la disponiblidad ya queda reservada.
    protected function attachSessionToCoachSchedule()
    {

        $coachSchedulesIds = collect($this->request->coach_schedule_id)->toArray();

        $this->assignSessionToIdsCommand->handle($coachSchedulesIds, $this->session);
    }

    //aquí básicamente metemos al estudiante en la sesión creando una nueva enrollment session
    protected function attachEnrollmentSession()
    {
        return $this->createEnrollmentSessionCommand->handle($this->session, $this->enrollment, $this->sessionOrder);
    }
}
