<?php

namespace App\Src\CoachDomain\Coach\Presenter;

use App\Src\CourseDomain\SessionDomain\Session\SessionReview\Service\CoachReviews;
use App\Src\UserDomain\User\Model\User;

class ShowAllReviewsResponse
{
    private User $coach;

    private CoachReviews $coachReviews;

    public function __construct(User $coach, CoachReviews $coachReviews)
    {

        $this->coach = $coach;
        $this->coachReviews = $coachReviews;
    }

    public function coach(): User
    {
        return $this->coach;
    }

    public function coachReviews(): CoachReviews
    {
        return $this->coachReviews;
    }
}
