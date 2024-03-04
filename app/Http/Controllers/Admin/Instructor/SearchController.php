<?php

namespace App\Http\Controllers\Admin\Instructor;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\Instructor\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\InstructorDomain\Instructor\Repository\InstructorRepository;
use App\Src\InstructorDomain\Instructor\Service\SearchForm;
use App\Src\Shared\Service\ColorFactory;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\UniversityDomain\Instructor\Request\SearchInstructorRequest;

class SearchController extends Controller
{
    use Breadcrumable, Orderable;

    private InstructorRepository $instructorRepository;

    public function __construct(InstructorRepository $instructorRepository)
    {
        $this->instructorRepository = $instructorRepository;
    }

    public function __invoke(SearchInstructorRequest $request)
    {
        $searchForm = app(SearchForm::class);
        $searchForm->config();

        $orderListing = $this->obtainOrderListing('lastname');

        $criteria = new CriteriaSearch($searchForm->model());

        $instructors = $this->instructorRepository->search($criteria, $orderListing, $this->instructorRepository->courseRelationship());

        $this->buildBreadcrumbAndSendToView(IndexBreadcrumb::SLUG);

        $colorFactory = app(ColorFactory::class);

        view()->share([
            'colorFactory' => $colorFactory,
            'instructors' => $instructors,
            'orderListing' => $orderListing,
            'searchForm' => $searchForm,
            'searchTeachignAssistant' => $request->searchTeachingAssistant(),
        ]);

        return view('admin.instructor.index');
    }
}
