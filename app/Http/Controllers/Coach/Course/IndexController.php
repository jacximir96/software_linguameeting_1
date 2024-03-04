<?php

namespace App\Http\Controllers\Coach\Course;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Course\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\CoachDomain\Course\Service\SearchForm;
use App\Src\CourseDomain\CourseCoach\Repository\CourseCoachRepository;
use App\Src\Shared\Service\CriteriaSearch;


class IndexController extends Controller
{
    use Breadcrumable;


    private CourseCoachRepository $courseCoachRepository;

    public function __construct (CourseCoachRepository $courseCoachRepository){

        $this->courseCoachRepository = $courseCoachRepository;
    }

    public function __invoke()
    {
        $coach = user();

        $searchForm = app(SearchForm::class);
        $searchForm->config();;

        $filter = ['coach_id' => $coach->id];
        $criteria = new CriteriaSearch($filter);

        $coursesCoach = $this->courseCoachRepository->search($criteria);

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'coach' => $coach,
            'coursesCoach' => $coursesCoach,
            'searchForm' => $searchForm,
        ]);

        return view('coach.course.index');
    }
}
