<?php

namespace App\Src\CoachDomain\CoachCoordinator\Action;

use App\Src\CoachDomain\CoachCoordinator\Model\CoachCoordinator;
use App\Src\UserDomain\User\Model\User;

class AssignCoordinatorAction
{
    public function handle(User $coachCoordinator, User $coach): CoachCoordinator
    {
        $item = new CoachCoordinator();
        $item->coordinator_id = $coachCoordinator->id;
        $item->coach_id = $coach->id;

        $item->save();

        return $item;
    }
}
