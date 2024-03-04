<?php

namespace App\Http\Controllers\Admin\University;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\UniversityDomain\University\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\UniversityDomain\University\Repository\UniversityRepository;
use App\Src\UniversityDomain\University\Request\SearchUniversityRequest;
use App\Src\UniversityDomain\University\Service\SearchForm;

class SearchController extends Controller
{
    use Breadcrumable, Orderable;

    private UniversityRepository $universityRepository;

    public function __construct(UniversityRepository $universityRepository)
    {
        $this->universityRepository = $universityRepository;
    }

    public function __invoke(SearchUniversityRequest $request)
    {
        $searchForm = app(SearchForm::class);
        $searchForm->config();

        $orderListing = $this->obtainOrderListing('name');

        $criteria = new CriteriaSearch($searchForm->model());

        $universities = $this->universityRepository->search($criteria, $orderListing);

        $searchForm = app(SearchForm::class);
        $searchForm->config();

        $this->buildBreadcrumbAndSendToView(IndexBreadcrumb::SLUG);

        view()->share([
            'orderListing' => $orderListing,
            'searchForm' => $searchForm,
            'universities' => $universities,
        ]);

        return view('admin.university.index');
    }
}
