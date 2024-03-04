<?php

namespace App\Http\Controllers\Admin\Course\Schedule;


use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\CourseDomain\Schedule\Request\ScheduleRequest;
use App\Src\CourseDomain\Schedule\Presenter\ScheduleWeeksPresenter;
use App\Src\TimeDomain\Date\Service\PaginatorPeriod;


class SearchController extends Controller
{

    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function __invoke(ScheduleRequest $request, Course $course)
    {

        $course->load($this->courseRepository->relations());

        $presenter = app(ScheduleWeeksPresenter::class);
        $viewData = $presenter->handle($course, user());

        $currentPeriod = $request->periodSelected();
        $paginator = new PaginatorPeriod($currentPeriod->get());

        view()->share([
            'course' => $course,
            'currentPeriod' => $currentPeriod,
            'page' => 1,
            'paginatorPeriod' => $paginator,
            'periodKey' => $viewData->searchForm()->periodKey(),
            'viewData' => $viewData,
        ]);

        return view('admin.course.schedule.index_weeks');
    }
}
