<?php
namespace App\Src\StudentRole\BookSession\Presenter;

use App\Src\CourseDomain\SessionDomain\Session\Repository\SessionRepository;

class LastMinutePresenter
{

    private SessionRepository $sessionRepository;

    public function __construct (SessionRepository $sessionRepository){

        $this->sessionRepository = $sessionRepository;
    }


    public function handle(LastMinuteQuery $query):LastMinuteResponse{

        $sessions = $this->sessionRepository->obtainForCourseInPeriod($query->getCourse(), $query->getPeriod());

        return new LastMinuteResponse($sessions);
    }
}
