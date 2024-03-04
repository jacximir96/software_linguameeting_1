<?php

namespace App\Http\Controllers\Admin\Coach\Review;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Repository\CoachReviewRepository;
use App\Src\UserDomain\User\Model\User;


class ShowAllController extends Controller
{

    private CoachReviewRepository $coachReviewRepository;

    public function __construct (CoachReviewRepository $coachReviewRepository){

        $this->coachReviewRepository = $coachReviewRepository;
    }

    public function __invoke(User $coach)
    {
        $reviews = $this->coachReviewRepository->obtainByCoachWithPagination($coach);

        view()->share([
            'coach' => $coach,
            'reviews' => $reviews,
        ]);

        return view('admin.coach.review.index_all');
    }
}
