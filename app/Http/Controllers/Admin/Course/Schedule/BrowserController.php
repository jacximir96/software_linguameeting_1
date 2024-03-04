<?php

namespace App\Http\Controllers\Admin\Course\Schedule;


use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\CourseDomain\Schedule\Presenter\ScheduleFlexPresenter;
use App\Src\CourseDomain\Schedule\Presenter\ScheduleWeeksPresenter;
use App\Src\TimeDomain\Date\Service\PaginatorPeriod;
use App\Src\TimeDomain\Date\Service\Period;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


class BrowserController extends Controller
{

    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function browserForWeeks(Course $course, int $page, string $periodKey = '')
    {
        request()->merge(['period' => $periodKey]);

        $presenter = app(ScheduleWeeksPresenter::class);
        $viewData = $presenter->handle($course, user());

        if (!empty($periodKey)){
            $currentPeriod = new Period($this->obtainPeriodFromKey($periodKey));
        }
        else{
            $currentPeriod = $viewData->periods()->nearToDate(Carbon::now());
        }

        $paginator = new PaginatorPeriod($currentPeriod->get());


        view()->share([
            'course' => $course,
            'currentPeriod' => $currentPeriod,
            'page' => $page,
            'paginatorPeriod' => $paginator,
            'periodKey' => $periodKey,
            'viewData' => $viewData,
        ]);

        return view('admin.course.schedule.index_weeks');
    }

    public function browserForFlex(Course $course, string $startDateWeek)
    {
        $course->load($this->courseRepository->relations());

        $startDateWeek = Carbon::parse($startDateWeek);
        $period = new CarbonPeriod($startDateWeek, $startDateWeek->copy()->endOfWeek());

        $presenter = app(ScheduleFlexPresenter::class);
        $viewData = $presenter->handle($course, $period, user());

        $currentPeriod = new Period($period);

        view()->share([
            'course' => $course,
            'currentPeriod' => $currentPeriod,
            'viewData' => $viewData,
        ]);

        if ($course->isFlex()) {
            return view('admin.course.schedule.index_flex');
        } else {
            return view('admin.course.schedule.index_weeks');
        }
    }

    private function obtainPeriodFromKey(string $periodKey): CarbonPeriod
    {

        $period = explode('_', $periodKey);
        $start = Carbon::parse($period[0]);
        $end = Carbon::parse($period[1]);

        return CarbonPeriod::create($start, $end);
    }
}
