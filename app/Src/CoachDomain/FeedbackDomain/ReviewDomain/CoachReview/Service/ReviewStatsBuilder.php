<?php
namespace App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service;

use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Repository\CoachReviewRepository;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;


class ReviewStatsBuilder
{

    private CoachReviewRepository $coachReviewRepository;

    public function __construct (CoachReviewRepository $coachReviewRepository){
        $this->coachReviewRepository = $coachReviewRepository;
    }

    public function buildCollection (Collection $coaches):ReviewsStatsCollection{

        $statsCollection = new ReviewsStatsCollection();

        foreach ($coaches as $coach){

            if ( ! $coach instanceof User){
                throw new \InvalidArgumentException('User is not coach');
            }

            $stats = $this->coachReviewRepository->reviewStats($coach);

            $review = new CoachReviewStats($coach, $stats);

            $statsCollection->put($review);
        }

        return $statsCollection;
    }
}
