<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Presenter;

use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use Illuminate\Support\Collection;

class SessionAssignment
{
    private Collection $enrollmentsSession;

    private ?Assignment $assignment;

    public function __construct()
    {

        $this->enrollmentsSession = collect();
        $this->assignment = null;
    }

    public function enrollmentsSession(): Collection
    {
        return $this->enrollmentsSession;
    }

    public function assignment(): ?Assignment
    {
        return $this->assignment;
    }

    public function addEnrollmentSession(EnrollmentSession $enrollmentSession)
    {
        $this->enrollmentsSession->push($enrollmentSession);
    }

    public function setAssignment(Assignment $assignment)
    {
        $this->assignment = $assignment;
    }

    public function hasAssignment(): bool
    {
        return ! is_null($this->assignment);
    }

    public function hasStudents(): bool
    {
        return $this->enrollmentsSession->count();
    }
}
