<?php
namespace App\Src\CourseDomain\Assignment\Presenter\StudentRole;

use App\Src\CourseDomain\Assignment\Service\AssignmentCollection;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Enrollment\Presenter\StudentRole\SessionsCollection;


class ShowAssignmentResponse
{

    private Enrollment $enrollment;

    private Section $section;

    private SessionsCollection $sessionWeeks;

    private AssignmentCollection $assignmentCollection;

    public function __construct (Enrollment $enrollment, Section $section, SessionsCollection $sessionWeeks, AssignmentCollection $assignmentCollection){

        $this->enrollment = $enrollment;
        $this->section = $section;
        $this->sessionWeeks = $sessionWeeks;
        $this->assignmentCollection = $assignmentCollection;
    }

    public function enrollment(): Enrollment
    {
        return $this->enrollment;
    }

    public function section(): Section
    {
        return $this->section;
    }

    public function sessionWeeks(): SessionsCollection
    {
        return $this->sessionWeeks;
    }

    public function assignmentCollection(): AssignmentCollection
    {
        return $this->assignmentCollection;
    }
}
