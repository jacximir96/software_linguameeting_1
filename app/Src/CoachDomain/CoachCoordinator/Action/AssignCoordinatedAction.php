<?php

namespace App\Src\CoachDomain\CoachCoordinator\Action;

use App\Src\CoachDomain\CoachCoordinator\Exception\CoachAlreadyBelongsToCoordinator;
use App\Src\CoachDomain\CoachCoordinator\Model\CoachCoordinator;
use App\Src\CoachDomain\CoachCoordinator\Repository\CoachCoordinatorRepository;
use App\Src\UserDomain\User\Model\User;

class AssignCoordinatedAction
{
    private CoachCoordinatorRepository $coachCoordinatorRepository;

    public function __construct(CoachCoordinatorRepository $coachCoordinatorRepository)
    {

        $this->coachCoordinatorRepository = $coachCoordinatorRepository;
    }

    public function handle(User $coachCoordinator, User $coach): CoachCoordinator
    {
        $this->checkCoachDoesNotBelongToAnyCoordinator($coach);

        $item = new CoachCoordinator();
        $item->coordinator_id = $coachCoordinator->id;
        $item->coach_id = $coach->id;

        $item->save();

        return $item;
    }

    private function checkCoachDoesNotBelongToAnyCoordinator(User $coach)
    {

        $item = $this->coachCoordinatorRepository->findByCoach($coach);

        if ($item) {
            throw new CoachAlreadyBelongsToCoordinator();
        }
    }
}
