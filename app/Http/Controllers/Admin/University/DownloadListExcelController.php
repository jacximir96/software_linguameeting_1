<?php

namespace App\Http\Controllers\Admin\University;

use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\UniversityDomain\University\Export\UniversitiesExport;
use App\Src\UniversityDomain\University\Repository\UniversityRepository;
use App\Src\UniversityDomain\University\Request\SearchUniversityRequest;
use Maatwebsite\Excel\Facades\Excel;

class DownloadListExcelController extends Controller
{
    use Orderable;

    private UniversityRepository $universityRepository;

    public function __construct(UniversityRepository $universityRepository)
    {
        $this->universityRepository = $universityRepository;
    }

    public function __invoke(SearchUniversityRequest $request)
    {

        $searchForm = app(\App\Src\UniversityDomain\University\Service\SearchForm::class);
        $searchForm->config();

        $orderListing = $this->obtainOrderListing('name');

        $criteria = new CriteriaSearch($searchForm->model());
        $criteria->withoutPaginate();

        $universities = $this->universityRepository->search($criteria, $orderListing);

        return Excel::download(new UniversitiesExport($universities), 'universities.xlsx');

    }
}
