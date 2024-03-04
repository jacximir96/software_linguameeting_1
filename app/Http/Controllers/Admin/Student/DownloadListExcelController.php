<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\StudentDomain\Student\Export\StudentsExport;
use App\Src\StudentDomain\Student\Repository\StudentRepository;
use App\Src\StudentDomain\Student\Request\SearchStudentRequest;
use App\Src\StudentDomain\Student\Service\SearchForm;
use Maatwebsite\Excel\Facades\Excel;

class DownloadListExcelController extends Controller
{
    use Orderable;

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
        $criteria->withoutPaginate();

        $students = $this->studentRepository->search($criteria, $orderListing);

        return Excel::download(new StudentsExport($students), 'students.xlsx');

    }
}
