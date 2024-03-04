<?php

namespace App\Src\StudentRole\BookSession\Action;

use App\Src\ActivityLog\Service\Properties\PropertyBuilder;
use App\Src\CoachDomain\CoachSchedule\Action\Command\AssignSessionToIdsCommand;
use App\Src\CoachDomain\CoachSchedule\Model\CoachSchedule;
use App\Src\CoachDomain\CoachSchedule\Repository\CoachScheduleRepository;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Action\Command\CreateEnrollmentSessionCommand;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use App\Src\CourseDomain\SessionDomain\Session\Action\Command\CreateSessionCommand;
use App\Src\CourseDomain\SessionDomain\Session\Action\Command\DeleteSessionCommand;
use App\Src\CourseDomain\SessionDomain\Session\Exception\SessionIsFull;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentRole\BookSession\Request\CreateSessionRequest;
use Spatie\Activitylog\Models\Activity;


class RescheduleSessionAction
{

    use TraitSession;

    //construct
    protected EnrollmentSessionRepository $enrollmentSessionRepository;

    protected CoachScheduleRepository $coachScheduleRepository;

    protected CreateSessionCommand $createSessionCommand;

    protected CreateEnrollmentSessionCommand $createEnrollmentSessionCommand;

    protected AssignSessionToIdsCommand $assignSessionToIdsCommand;

    private DeleteSessionCommand $deleteSessionCommand;

    //handle
    protected CreateSessionRequest $request;

    protected EnrollmentSession $enrollmentSession;

    //status
    protected Enrollment $enrollment;

    protected CoachSchedule $coachSchedule;

    protected Session $originSession; //sesión origen

    protected Session $session; //sesion de destino

    protected SessionOrder $sessionOrder;



    public function __construct(
        EnrollmentSessionRepository $enrollmentSessionRepository,
        CoachScheduleRepository $coachScheduleRepository,
        CreateSessionCommand $createSessionCommand,
        CreateEnrollmentSessionCommand $createEnrollmentSessionCommand,
        AssignSessionToIdsCommand $assignSessionToIdsCommand,
        DeleteSessionCommand $deleteSessionCommand,
    ) {
        $this->enrollmentSessionRepository = $enrollmentSessionRepository;
        $this->coachScheduleRepository = $coachScheduleRepository;
        $this->createSessionCommand = $createSessionCommand;
        $this->createEnrollmentSessionCommand = $createEnrollmentSessionCommand;
        $this->assignSessionToIdsCommand = $assignSessionToIdsCommand;
        $this->deleteSessionCommand = $deleteSessionCommand;
    }

    public function handle(CreateSessionRequest $request,EnrollmentSession $enrollmentSession): EnrollmentSession
    {

        $this->initialize($request, $enrollmentSession);

        $this->configSelectedSession();
        //en este punto $this->session tiene la sesión de destino (nueva o existente)

        $this->checkSessionNotIsFull();

        $this->attachEnrollmentSessionToNewSession();

        $this->deleteOriginSession();

        $this->registerActivity();

        return $enrollmentSession;
    }

    private function initialize(CreateSessionRequest $request, EnrollmentSession $enrollmentSession)
    {
        $this->request = $request;
        $this->enrollmentSession = $enrollmentSession;
        $this->originSession = $enrollmentSession->session;
        $this->sessionOrder = $enrollmentSession->sessionOrder();
        $this->enrollment = $enrollmentSession->enrollment;
    }

    private function checkSessionNotIsFull(){

        if ($this->session->occupation()->isFull()){
            throw new SessionIsFull();
        }
    }

    private function attachEnrollmentSessionToNewSession (){

        $this->enrollmentSession->session_id = $this->session->id;

        $this->enrollmentSession->day = $this->session->day;
        $this->enrollmentSession->start_time = $this->session->start_time;
        $this->enrollmentSession->end_time = $this->session->end_time;

        $this->enrollmentSession->save();

        $this->enrollmentSession->refresh();
    }

    private function deleteOriginSession(){

        if ($this->originSession->occupation()->isEmpty()){
            $this->deleteSessionCommand->handle($this->originSession);
        }

    }

    private function registerActivity(): Activity
    {
        $properties =  array_merge(
            PropertyBuilder::buildIp(request()->ip())->buildProperty('ip'),
            PropertyBuilder::buildEnrollmentSession($this->enrollmentSession)->buildProperty('enrollment_session', 'Enrollment'),
            PropertyBuilder::buildDatetime($this->originSession->scheduleSession()->start(), )->buildProperty('datetime_old','Old'),
            PropertyBuilder::buildDatetime($this->session->scheduleSession()->start(), )->buildProperty('datetime_new','New'),
        );

        return activity()
            ->causedBy(user())
            ->performedOn($this->enrollmentSession)
            ->withProperties($properties)
            ->log(config('linguameeting_log.activity.keys.student.sessions.reschedule'));
    }
}
