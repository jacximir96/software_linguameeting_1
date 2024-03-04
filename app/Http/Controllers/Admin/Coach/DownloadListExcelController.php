<?php

namespace App\Http\Controllers\Admin\Coach;

use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Coach\Export\CoachExport;
use App\Src\CoachDomain\Coach\Repository\CoachRepository;
use App\Src\InstructorDomain\Instructor\Service\SearchForm;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\UniversityDomain\Instructor\Request\SearchInstructorRequest;
use Maatwebsite\Excel\Facades\Excel;

class DownloadListExcelController extends Controller
{
    use Orderable;

    private CoachRepository $coachRepository;

    public function __construct(CoachRepository $coachRepository)
    {
        $this->coachRepository = $coachRepository;
    }

    public function __invoke(SearchInstructorRequest $request)
    {

        $searchForm = app(SearchForm::class);
        $searchForm->config();

        $orderListing = $this->obtainOrderListing('lastname');

        $criteria = new CriteriaSearch($searchForm->model());
        $criteria->withoutPaginate();

        $instructors = $this->coachRepository->search($criteria, $orderListing);

        return Excel::download(new CoachExport($instructors), 'coaches.xlsx');

    }
}
