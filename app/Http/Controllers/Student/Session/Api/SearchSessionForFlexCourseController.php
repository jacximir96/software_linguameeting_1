<?php
namespace App\Http\Controllers\Student\Session\Api;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\ReviewStatsBuilder;
use App\Src\CourseDomain\CoachingWeek\Repository\CoachingWeekRepository;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\CourseDomain\Schedule\Presenter\ScheduleFlexPresenter;
use App\Src\CourseDomain\Schedule\Presenter\ScheduleWeeksPresenter;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\TimeDomain\Date\Service\PaginatorPeriod;
use App\Src\TimeDomain\Date\Service\Period;


class SearchSessionForFlexCourseController extends Controller
{

    private CourseRepository $courseRepository;

    private CoachingWeekRepository $coachingWeekRepository;

    private ReviewStatsBuilder $reviewStatsBuilder;

    public function __construct(CourseRepository $courseRepository, CoachingWeekRepository $coachingWeekRepository, ReviewStatsBuilder $reviewStatsBuilder)
    {
        $this->courseRepository = $courseRepository;
        $this->coachingWeekRepository = $coachingWeekRepository;
        $this->reviewStatsBuilder = $reviewStatsBuilder;
    }

    public function __invoke(Enrollment $enrollment, int $sessionOrder, string $calendarPage = '')
    {
        $sessionOrder = new SessionOrder($sessionOrder);

        $course = $enrollment->course();

        $course->load($this->courseRepository->relations());
        $period = $enrollment->course()->period(); //$period php / utc

        $currentPeriod = new Period($period); //currentPeriod  App\Src\TimeDomain\Date\Service\Period;
        $paginator = new PaginatorPeriod($period);  //App\Src\TimeDomain\Date\Service\PaginatorPeriod

        $page = 1;
        if ( ! empty($calendarPage)){
            $page = (int)$calendarPage;
        }

        $presenter = app(ScheduleFlexPresenter::class);
        $viewData = $presenter->handle($course,  user());

        $reviewsStatsCollection = $this->reviewStatsBuilder->buildCollection($viewData->schedule()->coaches());

        view()->share([
            'course' => $course,
            'currentPeriod' => $currentPeriod,
            'enrollment' => $enrollment,
            'page' => $page,
            'paginatorPeriod' => $paginator,
            'periodKey' => $viewData->searchForm()->periodKey(),
            'reviewsStatsCollection' => $reviewsStatsCollection,
            'fromStudent' => true,
            'isCreateBook' => request()->has('isCreateBook'),
            'sessionOrder' => $sessionOrder,
            'userTimezone' => $this->userTimezone(),
            'utcTimezoneName' => TimeZone::TIMEZONE_UTC,
            'viewData' => $viewData,
        ]);

        return view('student.enrollment.session.api.index');
    }
}
