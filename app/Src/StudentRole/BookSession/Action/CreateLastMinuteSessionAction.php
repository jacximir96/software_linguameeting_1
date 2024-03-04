<?php
namespace App\Src\StudentRole\BookSession\Action;

use App\Src\ActivityLog\Service\Properties\PropertyBuilder;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Action\Command\CreateEnrollmentSessionCommand;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use Spatie\Activitylog\Models\Activity;


//crea un enrollment session asociado a una sesión desde last minute
class CreateLastMinuteSessionAction
{
    //construct
    private CreateEnrollmentSessionCommand $createEnrollmentSessionCommand;

    //handle
    private Enrollment $enrollment;

    private SessionOrder $sessionOrder;

    private Session $session;


    public function __construct(CreateEnrollmentSessionCommand $createEnrollmentSessionCommand,) {
        $this->createEnrollmentSessionCommand = $createEnrollmentSessionCommand;
    }

    public function handle(Enrollment $enrollment, SessionOrder $sessionOrder, Session $session): EnrollmentSession
    {

        $this->initialize($enrollment, $sessionOrder, $session);

        $this->registerActivity();

        return $this->createEnrollmentSessionCommand->handle($this->session, $this->enrollment, $this->sessionOrder);
    }

    private function initialize(Enrollment $enrollment, SessionOrder $sessionOrder, Session $session)
    {
        $this->enrollment = $enrollment;
        $this->sessionOrder = $sessionOrder;
        $this->session = $session;
    }

    private function registerActivity(): Activity
    {
        $properties =  array_merge(
            PropertyBuilder::buildIp(request()->ip())->buildProperty('ip'),
            PropertyBuilder::buildEnrollment($this->enrollment)->buildProperty('enrollment', 'Enrollment'),
            PropertyBuilder::buildSession($this->session)->buildProperty('session', 'Session'),
        );

        return activity()
            ->causedBy(user())
            ->performedOn($this->enrollment)
            ->withProperties($properties)
            ->log(config('linguameeting_log.activity.keys.student.sessions.last_minute'));
    }
}
