<?php
namespace App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service;


use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class ReviewsStatsCollection
{

    /*
     * CoachReviewStats
     */
    private Collection $reviews;

    public function __construct (){
        $this->reviews = collect();
    }

    public function put(CoachReviewStats $coachReviewStats){
        $this->reviews->put($coachReviewStats->coach()->id, $coachReviewStats);
    }

    public function getByCoach(User $coach):?CoachReviewStats{

        foreach ($this->reviews as $coachReviewStats){

            if ($coachReviewStats->isCoach($coach)){
                return $coachReviewStats;
            }
        }

        return null;
    }
}
