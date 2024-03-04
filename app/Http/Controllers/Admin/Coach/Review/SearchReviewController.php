<?php

namespace App\Http\Controllers\Admin\Coach\Review;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Repository\CoachReviewRepository;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\SearchForm;
use App\Src\Shared\Service\CriteriaSearch;

class SearchReviewController extends Controller
{
    use Breadcrumable, Orderable;

    private CoachReviewRepository $coachReviewRepository;

    public function __construct (CoachReviewRepository $coachReviewRepository){

        $this->coachReviewRepository = $coachReviewRepository;
    }

    public function __invoke()
    {
        $searchForm = app(SearchForm::class);
        $searchForm->config();

        $criteria = new CriteriaSearch($searchForm->model());

        $orderListing = $this->obtainOrderListing('id', 'desc');

        $reviews = $this->coachReviewRepository->search($criteria, $orderListing);

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'orderListing' => $orderListing,
            'reviews' => $reviews,
            'searchForm' => $searchForm,
        ]);

        return view('admin.coach.review.index');
    }
}
