<?php

namespace App\Src\CoachDomain\Coach\Presenter;

use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Service\Feedbacks;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\ReviewsWithStats;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class ShowCoachResponse
{
    private User $coach;

    private Collection $activity;

    private Collection $coordinatedCoaches;

    private Collection $coordinatedBy;

    private Collection $recordings;

    private ReviewsWithStats $reviewsWithStats;

    private Feedbacks $feedbacks;

    public function __construct(User $coach, Collection $activity, Collection $coordinatedCoaches, Collection $coordinatedBy, Collection $recordings, ReviewsWithStats $reviewsWithStats, Feedbacks $feedbacks)
    {

        $this->coach = $coach;
        $this->activity = $activity;
        $this->coordinatedCoaches = $coordinatedCoaches;
        $this->coordinatedBy = $coordinatedBy;
        $this->recordings = $recordings;
        $this->reviewsWithStats = $reviewsWithStats;
        $this->feedbacks = $feedbacks;
    }

    public function coach(): User
    {
        return $this->coach;
    }

    public function activity(): Collection
    {
        return $this->activity;
    }

    public function coordinatedCoaches(): Collection
    {
        return $this->coordinatedCoaches;
    }

    public function coordinatedBy(): Collection
    {
        return $this->coordinatedBy;
    }

    public function recordings(): Collection
    {
        return $this->recordings;
    }

    public function reviewsStats(): ReviewsWithStats
    {
        return $this->reviewsWithStats;
    }

    public function feedbacks(): Feedbacks
    {
        return $this->feedbacks;
    }
}
