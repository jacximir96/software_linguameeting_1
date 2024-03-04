<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\StudentDomain\Student\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\StudentDomain\Student\Repository\StudentRepository;
use App\Src\StudentDomain\Student\Service\SearchForm;

class IndexController extends Controller
{
    use Breadcrumable, Orderable;

    private StudentRepository $studentRepository;

    public function __construct (StudentRepository $studentRepository){

        $this->studentRepository = $studentRepository;
    }

    public function __invoke()
    {

        $searchForm = app(SearchForm::class);
        $searchForm->config();

        $criteria = new CriteriaSearch($searchForm->model());

        $orderListing = $this->obtainOrderListing('created_at', 'desc');

        $students = $this->studentRepository->search($criteria, $orderListing);

        $this->buildBreadcrumbAndSendToView(IndexBreadcrumb::SLUG);

        view()->share([
            'orderListing' => $orderListing,
            'students' => $students,
            'searchForm' => $searchForm,
        ]);

        return view('admin.student.index');
    }
}
