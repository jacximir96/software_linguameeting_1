<?php

namespace App\Src\CoachDomain\FeedbackDomain\InstructorEvaluation\Repository;

use App\Src\CoachDomain\FeedbackDomain\InstructorEvaluation\Model\InstructorEvaluation;
use App\Src\UserDomain\User\Model\User;

class InstructorEvaluationRepository
{
    public function obtainFromCoach(User $coach)
    {

        return InstructorEvaluation::query()
            ->where('coach_id', $coach->id)
            ->orderBy('id', 'desc')
            ->paginate(config('linguameeting.items_per_page'));

    }

    public function relation(): array
    {
        return [];
    }
}
