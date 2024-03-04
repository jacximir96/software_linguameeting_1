<?php

namespace App\Http\Controllers\Coach\Feedback\Student;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Presenter\Breadcrumb\Coach\IndexBreadcrumb;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Repository\CoachReviewRepository;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\CoachSearchForm;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReviewOption\Repository\CoachReviewOptionRepository;
use App\Src\Shared\Service\CriteriaSearch;


class SearchReviewController extends Controller
{
    use Breadcrumable, Orderable;

    private CoachReviewRepository $coachReviewRepository;

    private CoachReviewOptionRepository $coachReviewOptionRepository;


    public function __construct (CoachReviewRepository $coachReviewRepository, CoachReviewOptionRepository $coachReviewOptionRepository){

        $this->coachReviewRepository = $coachReviewRepository;
        $this->coachReviewOptionRepository = $coachReviewOptionRepository;
    }

    public function __invoke()
    {
        $coach = user();

        $reviewsStats = $this->coachReviewRepository->reviewStats($coach);
        $mostSelected = $this->coachReviewOptionRepository->obtainMoreSelectedByCoach($coach);

        $searchForm = app(CoachSearchForm::class);
        $searchForm->config();

        $criteriaFields = array_merge(['coach_id' => $coach->id], $searchForm->model());
        $criteria = new CriteriaSearch($criteriaFields);
        $orderListing = $this->obtainOrderListing('id', 'desc');
        $reviews = $this->coachReviewRepository->search($criteria, $orderListing);


        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'coach' => $coach,
            'mostSelected' => $mostSelected,
            'reviews' => $reviews,
            'reviewsStats' => $reviewsStats,
            'searchForm' => $searchForm,
        ]);

        return view('coach.feedback.student.index');
    }
}
