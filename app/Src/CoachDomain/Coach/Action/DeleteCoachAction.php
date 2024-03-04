<?php

namespace App\Src\CoachDomain\Coach\Action;

use App\Src\CourseDomain\SessionDomain\Session\Exception\CoachHasPendingSession;
use App\Src\CourseDomain\SessionDomain\Session\Repository\SessionRepository;
use App\Src\UserDomain\User\Model\User;

class DeleteCoachAction
{
    private SessionRepository $sessionRepository;

    public function __construct(SessionRepository $sessionRepository)
    {
        $this->sessionRepository = $sessionRepository;
    }

    public function handle(User $coach): User
    {

        $this->checkSessionsPending($coach);

        $coach->active = false;
        $coach->save();

        $coach->delete();

        return $coach;
    }

    private function checkSessionsPending(User $coach)
    {

        if ($this->sessionRepository->countPedingSessionsForCoach($coach)) {
            throw new CoachHasPendingSession();
        }
    }
}
