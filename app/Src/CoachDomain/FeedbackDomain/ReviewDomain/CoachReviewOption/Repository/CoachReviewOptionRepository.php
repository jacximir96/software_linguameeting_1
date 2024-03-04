<?php

namespace App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReviewOption\Repository;

use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReviewOption\Model\CoachReviewOption;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CoachReviewOptionRepository
{
    public function obtainMoreSelectedByCoach(User $coach): Collection
    {

        $result = CoachReviewOption::query()
            ->select('review_option_id', DB::raw('COUNT(*) as count'))
            ->with('option')
            ->whereHas('coachReview', function ($query) use ($coach) {
                $query->where('coach_id', $coach->id);
            })
            ->groupBy('review_option_id')
            ->orderBy('count', 'desc')
            ->get();

        $mostSelected = collect();

        foreach ($result as $selected) {
            $item = new MoreSelected($selected->option, $selected->count);
            $mostSelected->push($item);
        }

        return $mostSelected;
    }
}
