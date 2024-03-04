<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Action;

use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\SessionStatus\Repository\SessionStatusRepository;

class ResetSessionAction
{
    private SessionStatusRepository $sessionStatusRepository;

    public function __construct(SessionStatusRepository $sessionStatusRepository)
    {
        $this->sessionStatusRepository = $sessionStatusRepository;
    }

    public function handle(Session $session): Session
    {

        $status = $this->sessionStatusRepository->findUnspecified();

        $session->coach_id = null;
        $session->session_status_id = $status->id;
        $session->session_start = null;
        $session->session_end = null;
        $session->timezona_id = null;

    }
}
