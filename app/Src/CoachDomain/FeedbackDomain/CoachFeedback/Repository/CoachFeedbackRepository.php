<?php

namespace App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Repository;

use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Model\CoachFeedback;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class CoachFeedbackRepository
{
    public function obtainFromCoach(User $coach, int $limit = 5): Collection
    {

        return CoachFeedback::query()
            ->with($this->relations())
            ->where('coach_id', $coach->id)
            ->orderBy('moment', 'desc')
            ->limit($limit)
            ->get();
    }

    public function obtainFromCoachPaginate(User $coach, int $limit = 5)
    {

        return CoachFeedback::query()
            ->with($this->relations())
            ->where('coach_id', $coach->id)
            ->orderBy('moment', 'desc')
            ->paginate($limit);
    }

    private function relations(): array
    {
        return [
            'language',
        ];
    }
}
