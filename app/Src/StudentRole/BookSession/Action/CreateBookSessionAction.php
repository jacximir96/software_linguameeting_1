<?php

namespace App\Src\StudentRole\BookSession\Action;

use App\Src\CoachDomain\CoachSchedule\Action\Command\AssignSessionToIdsCommand;
use App\Src\CoachDomain\CoachSchedule\Model\CoachSchedule;
use App\Src\CoachDomain\CoachSchedule\Repository\CoachScheduleRepository;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Action\Command\CreateEnrollmentSessionCommand;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use App\Src\CourseDomain\SessionDomain\Session\Action\Command\CreateSessionCommand;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentRole\BookSession\Request\CreateSessionRequest;
use App\Src\StudentRole\BookSession\Service\Availability\TimeSlot;

//crea un enrollment session y crea una session si fuera necesario
class CreateBookSessionAction
{
    //construct
    private EnrollmentSessionRepository $enrollmentSessionRepository;

    private CoachScheduleRepository $coachScheduleRepository;

    private CreateSessionCommand $createSessionCommand;

    private CreateEnrollmentSessionCommand $createEnrollmentSessionCommand;

    private AssignSessionToIdsCommand $assignSessionToIdsCommand;

    //handle
    private CreateSessionRequest $request;

    private Enrollment $enrollment;

    private SessionOrder $sessionOrder;

    //status
    private CoachSchedule $coachSchedule;

    private Session $session;

    public function __construct(
        EnrollmentSessionRepository $enrollmentSessionRepository,
        CoachScheduleRepository $coachScheduleRepository,
        CreateSessionCommand $createSessionCommand,
        CreateEnrollmentSessionCommand $createEnrollmentSessionCommand,
        AssignSessionToIdsCommand $assignSessionToIdsCommand,
    ) {
        $this->enrollmentSessionRepository = $enrollmentSessionRepository;
        $this->coachScheduleRepository = $coachScheduleRepository;
        $this->createSessionCommand = $createSessionCommand;
        $this->createEnrollmentSessionCommand = $createEnrollmentSessionCommand;
        $this->assignSessionToIdsCommand = $assignSessionToIdsCommand;
    }

    public function handle(CreateSessionRequest $request, Enrollment $enrollment, SessionOrder $sessionOrder): EnrollmentSession
    {

        $this->initialize($request, $enrollment, $sessionOrder);

        $this->configSession();

        return $this->attachEnrollmentSession();
    }

    private function initialize(CreateSessionRequest $request, Enrollment $enrollment, SessionOrder $sessionOrder)
    {
        $this->request = $request;
        $this->enrollment = $enrollment;
        $this->sessionOrder = $sessionOrder;
    }

    private function configSession()
    {

        if ( ! $this->isNeedToCreateNewSession()) {
            $this->obtainSession();

            return;
        }

        $this->createSession();

        $this->attachSessionToCoachSchedule();

        return;
    }

    private function isNeedToCreateNewSession(): bool
    {

        $coachSchedulesIds = collect($this->request->coach_schedule_id);

        $this->coachSchedule = CoachSchedule::find($coachSchedulesIds->first());

        return is_null($this->coachSchedule->session);
    }

    private function createSession()
    {
        $timeSlot = $this->obtainTimeForNewSession();

        $this->session = $this->createSessionCommand->handle($this->enrollment->course(), $this->coachSchedule->coach, $this->coachSchedule, $timeSlot);
    }

    private function obtainSession()
    {

        $coachSchedulesIds = collect($this->request->coach_schedule_id);

        $this->coachSchedule = CoachSchedule::find($coachSchedulesIds->first());

        $this->session = $this->coachSchedule->session;

    }

    private function obtainTimeForNewSession(): TimeSlot
    {

        $coachSchedules = $this->coachScheduleRepository->obtainCoachSchedulesByIds($this->request->coach_schedule_id);

        return new TimeSlot($coachSchedules->first()->startAsTime(), $coachSchedules->last()->endAsTime());
    }

    private function attachSessionToCoachSchedule()
    {

        $coachSchedulesIds = collect($this->request->coach_schedule_id)->toArray();

        $this->assignSessionToIdsCommand->handle($coachSchedulesIds, $this->session);
    }

    private function attachEnrollmentSession()
    {
        return $this->createEnrollmentSessionCommand->handle($this->session, $this->enrollment, $this->sessionOrder);
    }
}
