<?php

namespace App\Src\CourseDomain\SessionDomain\EnrollmentSession\Service;

use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\Assignment\Repository\AssignmentRepository;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Service\ScheduleSession;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use Carbon\Carbon;

class EnrollmentSessionFacade
{
    private EnrollmentSession $enrollmentSession;

    public function __construct(EnrollmentSession $enrollmentSession)
    {
        $this->enrollmentSession = $enrollmentSession;
    }

    public function date(): Carbon
    {
        return $this->session()->date();
    }

    public function session(): Session
    {
        return $this->enrollmentSession->session;
    }

    public function sessionOrder(): SessionOrder
    {
        return $this->enrollmentSession->sessionOrder();
    }

    public function scheduleSession(): ScheduleSession
    {
        return $this->enrollmentSession->scheduleSession();
    }

    public function assignment(): ?Assignment
    {
        $assignmentRepository = app(AssignmentRepository::class);

        if ($this->enrollmentSession->coachingWeek) {
            return $assignmentRepository->findByCoachingWeek($this->enrollmentSession->coachingWeek);
        }

        return $assignmentRepository->findBySectionAndSessionOrder($this->enrollmentSession->enrollment->section, $this->sessionOrder());
    }
}
