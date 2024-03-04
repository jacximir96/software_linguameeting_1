<?php
namespace App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Action;

use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Model\CoachReview;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Request\CoachReviewRequest;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReviewOption\Model\CoachReviewOption;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\UserDomain\User\Model\User;


class CreateCoachReviewAction
{

    public function handle(CoachReviewRequest $request, EnrollmentSession $enrollmentSession, User $coach):CoachReview{


        $review = new CoachReview();
        $review->enrollment_session_id = $enrollmentSession->id;
        $review->coach_id =  $coach->id;
        $review->stars =  $request->rate;
        $review->comment =  $request->comment;

        $review->save();

        foreach ($request->review_option as $optionId){
            $option = new CoachReviewOption();
            $option->coach_review_id = $review->id;
            $option->review_option_id = $optionId;
            $option->save();
        }

        return $review;
    }
}
