<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\StudentDomain\Student\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\StudentDomain\Student\Repository\StudentRepository;
use App\Src\StudentDomain\Student\Request\SearchStudentRequest;
use App\Src\StudentDomain\Student\Service\SearchForm;

class SearchController extends Controller
{
    use Breadcrumable, Orderable;

    private StudentRepository $studentRepository;

    public function __construct (StudentRepository $studentRepository){

        $this->studentRepository = $studentRepository;
    }

    public function __invoke(SearchStudentRequest $request)
    {
        $searchForm = app(SearchForm::class);
        $searchForm->config();

        $orderListing = $this->obtainOrderListing('lastname');

        $criteria = new CriteriaSearch($searchForm->model());

        $students = $this->studentRepository->search($criteria, $orderListing);

        $this->buildBreadcrumbAndSendToView(IndexBreadcrumb::SLUG);

        view()->share([
            'students' => $students,
            'orderListing' => $orderListing,
            'searchForm' => $searchForm,
        ]);

        return view('admin.student.index');
    }
}
