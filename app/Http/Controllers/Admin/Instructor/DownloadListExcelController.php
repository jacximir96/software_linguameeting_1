<?php

namespace App\Http\Controllers\Admin\Instructor;

use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\Instructor\Repository\InstructorRepository;
use App\Src\InstructorDomain\Instructor\Service\SearchForm;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\UniversityDomain\Instructor\Request\SearchInstructorRequest;
use App\Src\UserDomain\User\Export\InstructorsExport;
use Maatwebsite\Excel\Facades\Excel;

class DownloadListExcelController extends Controller
{
    use Orderable;

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
        $criteria->withoutPaginate();

        $instructors = $this->instructorRepository->search($criteria, $orderListing);

        return Excel::download(new InstructorsExport($instructors), 'instructors.xlsx');

    }
}
