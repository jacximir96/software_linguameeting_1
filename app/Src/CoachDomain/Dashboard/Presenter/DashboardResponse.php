<?php

namespace App\Src\CoachDomain\Dashboard\Presenter;

use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\ReviewsStats;
use Illuminate\Support\Collection;

class DashboardResponse
{
    private ReviewsStats $reviewsStats;

    private Collection $reviewsMostSelected;

    private Notifications $notifications;

    private Messaging $messaging;

    private Collection $sessions;

    public function __construct(ReviewsStats $reviewsStats, Collection $reviewsMostSelected, Notifications $notifications, Messaging $messaging, Collection $sessions)
    {
        $this->reviewsStats = $reviewsStats;
        $this->reviewsMostSelected = $reviewsMostSelected;
        $this->notifications = $notifications;
        $this->messaging = $messaging;
        $this->sessions = $sessions;
    }

    public function reviewsStats(): ReviewsStats
    {
        return $this->reviewsStats;
    }

    public function reviewsMostSelected(): Collection
    {
        return $this->reviewsMostSelected;
    }

    public function notifications(): Notifications
    {
        return $this->notifications;
    }

    public function messaging(): Messaging
    {
        return $this->messaging;
    }

    public function sessions(): Collection
    {
        return $this->sessions;
    }
}
