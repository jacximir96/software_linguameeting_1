<?php

namespace App\Src\CoachDomain\CoachCoordinator\Repository;

use App\Src\CoachDomain\CoachCoordinator\Model\CoachCoordinator;
use App\Src\UserDomain\User\Model\User;

class CoachCoordinatorRepository
{
    public function obtainCoordinatedFromCoordinator(User $coordinator)
    {

        return CoachCoordinator::query()
            ->with('coach', 'coach.timezone')
            ->where('coordinator_id', $coordinator->id)
            ->get();
    }

    public function obtainCoordinatedFromCoordinatorWithPagination(User $coordinator)
    {

        return CoachCoordinator::query()
            ->select('coach_coordinator.*')
            ->with('coach')
            ->join('user', 'coach_coordinator.coach_id', '=', 'user.id')
            ->where('coordinator_id', $coordinator->id)
            ->orderBy('user.lastname')
            ->orderBy('user.name')
            ->paginate(config('linguameeting.items_per_page'));
    }

    public function findByCoordinatorAndCoach(User $coachCoordinator, User $coach)
    {

        return CoachCoordinator::query()
            ->where('coordinator_id', $coachCoordinator->id)
            ->where('coach_id', $coach->id)
            ->first();

    }

    public function findByCoach(User $coach)
    {

        return CoachCoordinator::query()
            ->where('coach_id', $coach->id)
            ->first();
    }
}
