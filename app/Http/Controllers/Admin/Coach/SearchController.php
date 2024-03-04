<?php

namespace App\Http\Controllers\Admin\Coach;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Coach\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\CoachDomain\Coach\Repository\CoachRepository;
use App\Src\CoachDomain\Coach\Service\SearchForm;
use App\Src\Shared\Service\CriteriaSearch;

class SearchController extends Controller
{
    use Breadcrumable, Orderable;

    private CoachRepository $coachRepository;

    public function __construct(CoachRepository $coachRepository)
    {
        $this->coachRepository = $coachRepository;
    }

    public function __invoke()
    {
        $searchForm = app(SearchForm::class);
        $searchForm->config();

        $criteria = new CriteriaSearch($searchForm->model());

        $orderListing = $this->obtainOrderListing('created_at', 'desc');

        $coaches = $this->coachRepository->search($criteria, $orderListing);

        $this->buildBreadcrumbAndSendToView(IndexBreadcrumb::SLUG);

        view()->share([
            'orderListing' => $orderListing,
            'searchForm' => $searchForm,
            'coaches' => $coaches,
        ]);

        return view('admin.coach.index');
    }
}
