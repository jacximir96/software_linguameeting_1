<?php

namespace App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Action;

use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Model\CoachReview;
use Carbon\Carbon;

class MarkFavoriteAction
{
    public function handle(CoachReview $coachReview): CoachReview
    {

        if ($coachReview->isFavorite()) {
            $coachReview->favorited_at = null;
        } else {
            $coachReview->favorited_at = Carbon::now();
        }

        $coachReview->save();

        return $coachReview;
    }
}
