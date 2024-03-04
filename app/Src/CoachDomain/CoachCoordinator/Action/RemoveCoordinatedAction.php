<?php

namespace App\Src\CoachDomain\CoachCoordinator\Action;

use App\Src\CoachDomain\CoachCoordinator\Repository\CoachCoordinatorRepository;
use App\Src\UserDomain\User\Model\User;

class RemoveCoordinatedAction
{
    private CoachCoordinatorRepository $coachCoordinatorRepository;

    public function __construct(CoachCoordinatorRepository $coachCoordinatorRepository)
    {

        $this->coachCoordinatorRepository = $coachCoordinatorRepository;
    }

    public function handle(User $coachCoordinator, User $coach)
    {

        $coachCoordinator = $this->coachCoordinatorRepository->findByCoordinatorAndCoach($coachCoordinator, $coach);

        if ($coachCoordinator) {
            $coachCoordinator->delete();
        }
    }
}
