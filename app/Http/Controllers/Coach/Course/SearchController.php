<?php

namespace App\Http\Controllers\Coach\Course;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Course\Request\SearchCourseRequest;
use App\Src\CourseDomain\CourseCoach\Repository\CourseCoachRepository;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\StudentDomain\Student\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\StudentDomain\Student\Repository\StudentRepository;
use App\Src\CoachDomain\Course\Service\SearchForm;


class SearchController extends Controller
{
    use Breadcrumable;

    private CourseCoachRepository $courseCoachRepository;


    public function __construct (CourseCoachRepository $courseCoachRepository){

        $this->courseCoachRepository = $courseCoachRepository;
    }

    public function __invoke(SearchCourseRequest $request)
    {

        $coach = user();

        $searchForm = app(SearchForm::class);
        $searchForm->config();

        $filter = array_merge(['coach_id' => $coach->id], $searchForm->model());
        $criteria = new CriteriaSearch($filter);

        $coursesCoach = $this->courseCoachRepository->search($criteria);

        $this->buildBreadcrumbAndSendToView(IndexBreadcrumb::SLUG);

        view()->share([
            'coach' => $coach,
            'coursesCoach' => $coursesCoach,
            'searchForm' => $searchForm,
        ]);

        return view('coach.course.index');
    }
}
