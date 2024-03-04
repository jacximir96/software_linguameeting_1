<?php
namespace App\Src\StudentRole\BookSession\Action;

//crea un enrollment session y crea una session si fuera necesario
use App\Src\ActivityLog\Service\Properties\PropertyBuilder;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Action\Command\DeleteEnrollmentSessionCommand;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Action\Command\DeleteSessionCommand;
use App\Src\StudentDomain\Makeup\Exception\EnrollmentDoesntHaveMakeup;
use App\Src\StudentDomain\Makeup\Repository\MakeupRepository;
use Spatie\Activitylog\Models\Activity;

class AssociateMakeupWithBookedSessionAction
{

    private MakeupRepository $makeupRepository;

    private DeleteEnrollmentSessionCommand $deleteEnrollmentSessionCommand;

    private DeleteSessionCommand $deleteSessionCommand;

    public function __construct (MakeupRepository $makeupRepository, DeleteEnrollmentSessionCommand $deleteEnrollmentSessionCommand, DeleteSessionCommand $deleteSessionCommand){

        $this->makeupRepository = $makeupRepository;
        $this->deleteEnrollmentSessionCommand = $deleteEnrollmentSessionCommand;
        $this->deleteSessionCommand = $deleteSessionCommand;
    }

    public function handle(EnrollmentSession $newEnrollmentSession, EnrollmentSession $missedEnrollmentSession):EnrollmentSession{

        $this->assignMakeup($newEnrollmentSession, $missedEnrollmentSession);

        $this->deleteMissedEnrollmentSession($missedEnrollmentSession);

        $this->registerActivity($newEnrollmentSession);

        return $newEnrollmentSession;
    }

    private function assignMakeup(EnrollmentSession $newEnrollmentSession, EnrollmentSession $missedEnrollmentSession): void
    {
        $makeup = $this->makeupRepository->obtainFirstNotUsedByEnrollment($newEnrollmentSession->enrollment);

        if (is_null($makeup)) {
            throw new EnrollmentDoesntHaveMakeup();
        }

        $newEnrollmentSession->makeup_id = $makeup->id;
        $newEnrollmentSession->session_id_recovered = $missedEnrollmentSession->id;

        $newEnrollmentSession->save();
    }

    private function deleteMissedEnrollmentSession(EnrollmentSession $missedEnrollmentSession): void
    {

        $session = $missedEnrollmentSession->session;

        $this->deleteEnrollmentSessionCommand->handle($missedEnrollmentSession, false);

        $session = $session->fresh();

        if ($session->occupation()->isEmpty()){
            $this->deleteSessionCommand->handle($session);
        }
    }

    private function registerActivity (EnrollmentSession $enrollmentSession):Activity{

        $properties =  array_merge(
            PropertyBuilder::buildIp(request()->ip())->buildProperty('ip'),
            PropertyBuilder::buildEnrollmentSessionWithMakeup($enrollmentSession)->buildProperty('enrollment_session', 'Enrollment')
        );

        return  activity()
            ->causedBy(user())
            ->performedOn($enrollmentSession)
            ->withProperties($properties)
            ->log(config('linguameeting_log.activity.keys.student.sessions.makeup.use_in_session'));
    }
}
