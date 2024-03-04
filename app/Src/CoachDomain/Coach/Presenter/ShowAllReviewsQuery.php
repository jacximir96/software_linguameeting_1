<?php

namespace App\Src\CoachDomain\Coach\Presenter;

use App\Src\CourseDomain\SessionDomain\Session\SessionReview\Service\CoachReviews;
use App\Src\CourseDomain\SessionDomain\Session\SessionReview\Service\SessionReviewFake;
use App\Src\UserDomain\User\Model\User;

class ShowAllReviewsQuery
{
    private User $coach;

    public function handle(User $coach): ShowAllReviewsResponse
    {

        $this->initialize($coach);

        $reviews = $this->obtainSessionsReviews();

        return new ShowAllReviewsResponse($this->coach, $reviews);
    }

    private function initialize(User $coach)
    {
        $this->coach = $coach;
    }

    public function obtainSessionsReviews(): CoachReviews
    {

        $reviews = new CoachReviews($this->coach, 54, 4.5);

        for ($i = 1; $i <= 5; $i++) {

            $review = new SessionReviewFake();
            $reviews->addReview($review);
        }

        return $reviews;
    }
}
