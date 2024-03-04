<?php

namespace App\Src\CoachDomain\CoachCoordinator\Action;

use App\Src\CoachDomain\CoachCoordinator\Repository\CoachCoordinatorRepository;
use App\Src\UserDomain\User\Model\User;

class ChangeCoordinatorAction
{
    private CoachCoordinatorRepository $coachCoordinatorRepository;

    private AssignCoordinatorAction $assignCoordinatorAction;

    public function __construct(CoachCoordinatorRepository $coachCoordinatorRepository, AssignCoordinatorAction $assignCoordinatorAction)
    {
        $this->coachCoordinatorRepository = $coachCoordinatorRepository;
        $this->assignCoordinatorAction = $assignCoordinatorAction;
    }

    public function handle(User $coach, User $newCoordinator)
    {

        $coachCoordinator = $this->coachCoordinatorRepository->findByCoach($coach);

        if ($coachCoordinator) {

            $coachCoordinator->coordinator_id = $newCoordinator->id;
            $coachCoordinator->save();

            return $coachCoordinator;
        }

        return $this->assignCoordinatorAction->handle($newCoordinator, $coach);
    }
}
