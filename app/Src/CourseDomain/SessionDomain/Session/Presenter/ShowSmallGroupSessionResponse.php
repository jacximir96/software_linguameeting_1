<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Presenter;

use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use Illuminate\Support\Collection;

class ShowSmallGroupSessionResponse
{
    private Session $session;

    private SessionAssignment $sessionAssignment;

    private Collection $makeupSessionsAssignments;

    public function __construct(Session $session, SessionAssignment $sessionAssignment, Collection $makeupSessionAssignments)
    {

        $this->session = $session;
        $this->sessionAssignment = $sessionAssignment;
        $this->makeupSessionsAssignments = $makeupSessionAssignments;
    }

    public function session(): Session
    {
        return $this->session;
    }

    public function sessionAssignment(): SessionAssignment
    {
        return $this->sessionAssignment;
    }

    public function makeupSessionsAssignments(): Collection
    {
        return $this->makeupSessionsAssignments;
    }
}
