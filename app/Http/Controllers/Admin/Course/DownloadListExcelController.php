<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Export\CoursesExport;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\InstructorDomain\Instructor\Service\SearchForm;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\UniversityDomain\Instructor\Request\SearchInstructorRequest;
use Maatwebsite\Excel\Facades\Excel;

class DownloadListExcelController extends Controller
{
    use Orderable;

    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function __invoke(SearchInstructorRequest $request)
    {

        $searchForm = app(SearchForm::class);
        $searchForm->config();

        $orderListing = $this->obtainOrderListing('created_at', 'desc');

        $criteria = new CriteriaSearch($searchForm->model());
        $criteria->withoutPaginate();

        $courses = $this->courseRepository->search($criteria, $orderListing);

        return Excel::download(new CoursesExport($courses), 'courses.xlsx');

    }
}
