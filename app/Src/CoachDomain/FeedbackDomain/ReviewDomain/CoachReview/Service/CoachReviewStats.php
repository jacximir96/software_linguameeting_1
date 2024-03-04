<?php
namespace App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service;

use App\Src\UserDomain\User\Model\User;


class CoachReviewStats
{
    private User $coach;

    private ReviewsStats $reviewsStats;

    public function __construct (User $coach, ReviewsStats $reviewsStats){
        $this->coach = $coach;
        $this->reviewsStats = $reviewsStats;
    }

    public function coach(): User
    {
        return $this->coach;
    }

    public function reviewsStats(): ReviewsStats
    {
        return $this->reviewsStats;
    }

    public function isCoach (User $coach):bool{
        return $this->coach->isSame($coach);
    }
}
