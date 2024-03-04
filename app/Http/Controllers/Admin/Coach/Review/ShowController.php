<?php

namespace App\Http\Controllers\Admin\Coach\Review;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Model\CoachReview;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Repository\CoachReviewRepository;


class ShowController extends Controller
{

    private CoachReviewRepository $coachReviewRepository;

    public function __construct (CoachReviewRepository $coachReviewRepository){

        $this->coachReviewRepository = $coachReviewRepository;
    }

    public function __invoke(CoachReview $coachReview)
    {
        $coachReview->load($this->coachReviewRepository->relations());

        view()->share([
            'coach' => $coachReview->coach,
            'review' => $coachReview,
        ]);

        return view('admin.coach.review.show');
    }
}
