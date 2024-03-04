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
use App\Src\StudentDomain\Enrollment\Exception\EnrollmentDoesntExtraSession;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\ExtraSession\Model\ExtraSession;
use App\Src\StudentDomain\ExtraSession\Repository\ExtraSessionRepository;
use App\Src\StudentRole\BookSession\Request\CreateSessionRequest;

//crea un enrollment session como extra sesión
class CreateExtraSessionAction
{

    use TraitSession;

    //construct
    private EnrollmentSessionRepository $enrollmentSessionRepository;

    private CoachScheduleRepository $coachScheduleRepository;

    private CreateSessionCommand $createSessionCommand;

    private CreateEnrollmentSessionCommand $createEnrollmentSessionCommand;

    private AssignSessionToIdsCommand $assignSessionToIdsCommand;

    private ExtraSessionRepository $extraSessionRepository;

    //handle
    private CreateSessionRequest $request;

    private Enrollment $enrollment;

    private SessionOrder $sessionOrder;

    //status

    private EnrollmentSession $enrollmentSession;

    private CoachSchedule $coachSchedule;

    private Session $session;

    private ExtraSession $extraSession;


    public function __construct(
        //usados en trait
        EnrollmentSessionRepository $enrollmentSessionRepository,
        CoachScheduleRepository $coachScheduleRepository,
        CreateSessionCommand $createSessionCommand,
        CreateEnrollmentSessionCommand $createEnrollmentSessionCommand,
        AssignSessionToIdsCommand $assignSessionToIdsCommand,

        ExtraSessionRepository $extraSessionRepository,
    ) {
        $this->enrollmentSessionRepository = $enrollmentSessionRepository;
        $this->coachScheduleRepository = $coachScheduleRepository;
        $this->createSessionCommand = $createSessionCommand;
        $this->createEnrollmentSessionCommand = $createEnrollmentSessionCommand;
        $this->assignSessionToIdsCommand = $assignSessionToIdsCommand;
        $this->extraSessionRepository = $extraSessionRepository;
    }

    public function handle(CreateSessionRequest $request, Enrollment $enrollment, SessionOrder $sessionOrder): EnrollmentSession
    {

        $this->initialize($request, $enrollment, $sessionOrder);

        $this->configSession();

        $this->createEnrollmentSession();

        $this->configExtraSession();

        $this->assignExtraSessionToEnrollmentSession();

        return $this->enrollmentSession;

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

    public function createEnrollmentSession (){
        $this->enrollmentSession = $this->attachEnrollmentSession();
    }

    private function configExtraSession (){

        $this->extraSession = $this->extraSessionRepository->obtainFirstAvailableFromEnrollment($this->enrollment);

        if (is_null($this->extraSession)){
            throw new EnrollmentDoesntExtraSession();
        }
    }

    private function assignExtraSessionToEnrollmentSession():EnrollmentSession{

        if ($this->request->has('coaching_week_id')){
            $this->enrollmentSession->coaching_week_id = $this->request->coaching_week_id;
        }

        $this->enrollmentSession->extra_session_id = $this->extraSession->id;
        $this->enrollmentSession->save();

        return $this->enrollmentSession;
    }
}
