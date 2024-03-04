<?php

namespace App\Src\CoachDomain\FeedbackDomain\ManagerEvaluation\Repository;

use App\Src\CoachDomain\FeedbackDomain\ManagerEvaluation\Model\ManagerEvaluation;
use App\Src\UserDomain\User\Model\User;

class ManagerEvaluationRepository
{
    public function obtainFromCoach(User $coach)
    {

        return ManagerEvaluation::query()
            ->where('coach_id', $coach->id)
            ->orderBy('id', 'desc')
            ->get();

    }

    public function relation(): array
    {

        return [
            'coach',
            'file',
        ];
    }
}
