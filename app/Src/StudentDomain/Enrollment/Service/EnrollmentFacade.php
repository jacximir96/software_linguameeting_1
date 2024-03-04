<?php

namespace App\Src\StudentDomain\Enrollment\Service;

use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Service\EnrollmentSessionFacade;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use Illuminate\Support\Collection;

class EnrollmentFacade
{
    private Enrollment $enrollment;

    public function __construct(Enrollment $enrollment)
    {

        $this->enrollment = $enrollment;
    }

    public function hasSessionInCoachingWeek(CoachingWeek $coachingWeek): bool
    {

        return (bool) $this->enrollmentSessionByCoachingWeek($coachingWeek);
    }

    public function enrollmentSessionByCoachingWeek(CoachingWeek $coachingWeek): ?EnrollmentSessionFacade
    {

        foreach ($this->enrollmentSession() as $enrollmentSession) {
            if ($enrollmentSession->isCoachingWeek($coachingWeek)) {
                return new EnrollmentSessionFacade($enrollmentSession);
            }
        }

        return null;
    }

    public function enrollmentSession(): Collection
    {
        return $this->enrollment->enrollmentSession;
    }
}
