<?php

namespace App\Http\Controllers\Instructor\Course;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Coach\Repository\CoachRepository;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\ReviewStatsBuilder;
use App\Src\ConversationGuideDomain\Guide\Repository\GuideRepository;
use App\Src\CourseDomain\CoachingForm\Service\InstructionsFinder;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter\OneOnOneFlexPresenter;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter\OneOnOneWeekPresenter;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter\SmallGroupFlexPresenter;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter\SmallGroupWeekPresenter;
use App\Src\CourseDomain\Schedule\Presenter\ScheduleFlexPresenter;
use App\Src\CourseDomain\Schedule\Presenter\ScheduleWeeksPresenter;
use App\Src\InstructorDomain\InstructorCourse\Presenter\Breadcrumb\Instructor\ShowCourseBreadcrumb;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Http\Controllers\Admin\Course\CoachingForm\Wizard\Summarizable;
use App\Src\TimeDomain\Date\Service\PaginatorPeriod;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Src\InstructorDomain\Canvas\Repository\CanvasRepository;

class ShowController extends Controller
{
    use Breadcrumable, Summarizable;

    private CourseRepository $courseRepository;
    private CanvasRepository $canvasRepository;
    private CoachRepository $coachRepository;
    private GuideRepository $guideRepository;
    private ReviewStatsBuilder $reviewStatsBuilder;

    public function __construct(
        CourseRepository $courseRepository,
        CanvasRepository $canvasRepository,
        CoachRepository $coachRepository,
        GuideRepository $guideRepository,
        ReviewStatsBuilder $reviewStatsBuilder
    ) {

        $this->courseRepository = $courseRepository;
        $this->canvasRepository = $canvasRepository;
        $this->coachRepository = $coachRepository;
        $this->guideRepository = $guideRepository;
        $this->reviewStatsBuilder = $reviewStatsBuilder;
    }


    public function __invoke(Course $course)
    {

        try {

            $instructor = user();

            $breadcrumb = new ShowCourseBreadcrumb($course);
            $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

            $course->load($this->courseRepository->relationsWithSections());
            $canvas = $this->canvasRepository->canvasInstructor($course, $instructor);

            $canvas_id = "";
            if ( ! empty($canvas)) {
                $canvas_id = $canvas->canvas_course_id;
            }

            $this->buildCourseSummaryFromCourse($course);

            $coaches = $this->coachRepository->coachWithSessionsInCourse($course);
            $reviewsStatsCollection = $this->reviewStatsBuilder->buildCollection($coaches);

            $this->configAssignments($course);

            $this->configSchedule($course);

            $guideByDefault = $this->obtainGuideByDefault($course);

            view()->share([
                'canvas_id' => $canvas_id,
                'coaches' => $coaches,
                'course' => $course,
                'guide' => $guideByDefault,
                'linguaMoney' => new LinguaMoney(),
                'loadExpanderJs' => true,
                'reviewsStatsCollection' => $reviewsStatsCollection,
                'timezone' => $this->userTimezone()
            ]);

            return view('instructor.course.show_tab');

        } catch (\Throwable $exception) {

            dd($exception);

            Log::error('There is an error when show course', [
                'course' => $course,
                'exception' => $exception,
            ]);

            flash(trans('coaching_form.exception.error_general'))->error();

            return back();
        }
    }

    private function configSchedule(Course $course)
    {

        if ($course->isFlex()) {
            $presenter = app(ScheduleFlexPresenter::class);
            $viewDataSchedule = $presenter->handle($course, user());
        } else {
            $presenter = app(ScheduleWeeksPresenter::class);
            $viewDataSchedule = $presenter->handle($course, user(), false, false);
        }

        $currentPeriod = $viewDataSchedule->periods()->nearToDate(Carbon::now());

        view()->share([
            'currentPeriod' => $currentPeriod,
            'page' => 1,
            'viewData' => $viewDataSchedule,
        ]);


        if ( ! $course->isFlex()) {

            if ($currentPeriod) {
                $paginator = new PaginatorPeriod($currentPeriod->get());
                view()->share([
                    'paginatorPeriod' => $paginator,
                    'periodKey' => '',
                ]);
            }
        }
    }

    private function configAssignments(Course $course)
    {

        $instructionsFinder = new InstructionsFinder();

        $presenter = $this->obtainPresenter($course);
        $viewDataSection = $presenter->handle($course);

        view()->share([
            'instructionsFinder' => $instructionsFinder,
            'isSmallGroup' => $course->conversationPackage->sessionType->isSmallGroup(),
            'viewDataSection' => $viewDataSection,
        ]);
    }

    private function obtainPresenter(Course $course)
    {

        if ($course->isFlex()) {

            if ($course->conversationPackage->sessionType->isSmallGroup()) {
                return app(SmallGroupFlexPresenter::class);
            }

            return app(OneOnOneFlexPresenter::class); //**
        }

        //course with coaching weeks...

        if ($course->conversationPackage->sessionType->isSmallGroup()) {
            return app(SmallGroupWeekPresenter::class);
        }

        return app(OneOnOneWeekPresenter::class);
    }

    private function obtainGuideByDefault(Course $course)
    {

        $guide = $course->conversationGuide;

        if ($guide->hasLingroWithoutGuide()) {
            return $this->guideRepository->obtainLinguameetingSpanish();

        }

        return $guide;
    }
}
