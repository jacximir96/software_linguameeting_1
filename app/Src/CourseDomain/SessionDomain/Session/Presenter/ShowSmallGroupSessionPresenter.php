<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Presenter;

use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Service\EnrollmentSessionFacade;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use Illuminate\Support\Collection;

class ShowSmallGroupSessionPresenter
{
    private SessionAssignment $sessionAssignment;

    private SessionAssignment $makeupSessionAssignment;

    private Collection $makeupSessionsAssigngments;

    public function __construct(SessionAssignment $sessionAssignment, SessionAssignment $makeupSessionAssignment)
    {

        $this->sessionAssignment = $sessionAssignment;
        $this->makeupSessionAssignment = $makeupSessionAssignment;
        $this->makeupSessionsAssigngments = collect();
    }

    public function handle(Session $session):ShowSmallGroupSessionResponse
    {

        $this->initialize();

        foreach ($session->enrollmentSession as $enrollmentSession) {

            if ($enrollmentSession->makeup) {
                $this->addEnrollmentSession($this->makeupSessionAssignment, $enrollmentSession);
            } else {
                $this->addEnrollmentSession($this->sessionAssignment, $enrollmentSession);
            }
        }

        return new ShowSmallGroupSessionResponse($session, $this->sessionAssignment, $this->makeupSessionsAssigngments);
    }

    private function initialize()
    {
        $this->enrollmentSession = new SessionAssignment();
        $this->makeupEnrollmentSession = new SessionAssignment();
        $this->assignment = null;
    }

    private function addEnrollmentSession(SessionAssignment $sessionAssignment, EnrollmentSession $enrollmentSession)
    {

        $sessionAssignment->addEnrollmentSession($enrollmentSession);

        if ($enrollmentSession->makeup) {

            $enrollmenSessionRecovered = $enrollmentSession->recovered;
            if ($enrollmenSessionRecovered){
                $assignment = $this->obtainAssignment($enrollmenSessionRecovered);

                if ($assignment) {
                    $sessionAssignment->setAssignment($assignment);
                }

                $this->makeupSessionsAssigngments->push($sessionAssignment);
            }
            else{
                //es posible que no existe una sesión de recuperación si el makeup va sobre un coaching week perdido y no sobre una clase específica
                if ($enrollmentSession->hasCoachingWeek()){
                    $assignment = Assignment::where('week_id', $enrollmentSession->coaching_week_id)->first();
                    $this->makeupSessionsAssigngments->push($assignment);
                }
            }

        } else {

            if (! $sessionAssignment->hasAssignment()) {

                $assignment = $this->obtainAssignment($enrollmentSession);

                if ($assignment) {
                    $sessionAssignment->setAssignment($assignment);
                }
            }
        }
    }

    private function obtainAssignment(EnrollmentSession $enrollmentSession)
    {

        $enrollmentSessionFacade = app(EnrollmentSessionFacade::class, ['enrollmentSession' => $enrollmentSession]);

        return $enrollmentSessionFacade->assignment();
    }
}
