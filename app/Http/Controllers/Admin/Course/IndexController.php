<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\CourseDomain\Course\Service\SearchForm;
use App\Src\Shared\Service\CriteriaSearch;

class IndexController extends Controller
{
    use Breadcrumable, Orderable;

    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function __invoke()
    {
        $searchForm = app(SearchForm::class);
        $searchForm->config();

        $orderListing = $this->obtainOrderListing('created_at', 'desc');

        $criteria = new CriteriaSearch($searchForm->model());

        $extraFlags ['withCount'] = 'enrollment';
        $extraFlags ['withSection'] = true;
        $courses = $this->courseRepository->search($criteria, $orderListing, $extraFlags);

        $this->buildBreadcrumbAndSendToView(IndexBreadcrumb::SLUG);

        view()->share([
            'courses' => $courses,
            'orderListing' => $orderListing,
            'searchForm' => $searchForm,
            'timezone' => $this->userTimezone(),
        ]);

        return view('admin.course.index');
    }
}
