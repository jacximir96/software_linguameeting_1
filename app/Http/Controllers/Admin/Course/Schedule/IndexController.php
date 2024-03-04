<?php

namespace App\Http\Controllers\Admin\Course\Schedule;


use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\CourseDomain\Schedule\Presenter\ScheduleFlexPresenter;
use App\Src\CourseDomain\Schedule\Presenter\ScheduleWeeksPresenter;
use App\Src\TimeDomain\Date\Service\PaginatorPeriod;
use Carbon\Carbon;


class IndexController extends Controller
{

    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function __invoke(Course $course)
    {

        $course->load($this->courseRepository->relations());

        if ($course->isFlex()){
            $presenter = app(ScheduleFlexPresenter::class);
            $viewData = $presenter->handle($course, $course->period(), user());
        }
        else{
            $presenter = app(ScheduleWeeksPresenter::class);
            $viewData = $presenter->handle($course, user());
        }

        $currentPeriod = $viewData->periods()->nearToDate(Carbon::now());

        view()->share([
            'course' => $course,
            'currentPeriod' => $currentPeriod,
            'page' => 1,
            'viewData' => $viewData,
        ]);

        if ($course->isFlex()){
            return view('admin.course.schedule.index_flex');
        }
        else{

            if ($currentPeriod){
                $paginator = new PaginatorPeriod($currentPeriod->get());
                view()->share([
                    'paginatorPeriod' => $paginator,
                    'periodKey' => '',
                ]);
            }

            return view('admin.course.schedule.index_weeks');
        }
    }
}
