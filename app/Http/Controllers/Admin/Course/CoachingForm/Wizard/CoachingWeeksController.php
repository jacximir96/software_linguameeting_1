<?php

namespace App\Http\Controllers\Admin\Course\CoachingForm\Wizard;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\CoachingForm\Action\CourseToWeeksConvertAction;
use App\Src\CourseDomain\CoachingForm\Action\MakeUpWeekDeleteAction;
use App\Src\CourseDomain\CoachingForm\Action\CourseAsFlexUpdateAction;
use App\Src\CourseDomain\CoachingForm\Action\CourseAsNormalUpdateAction;
use App\Src\CourseDomain\CoachingForm\Action\MakeUpWeekUpdateAction;
use App\Src\CourseDomain\CoachingForm\Exception\StudentsWithSessionsToChangeWeeks;
use App\Src\CourseDomain\CoachingForm\Presenter\Breadcrumb\CoachingFormBreadcrumb;
use App\Src\CourseDomain\CoachingForm\Request\CoachingWeeksRequest;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\CoachingWeeksForm;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\SessionWizardFactory;
use App\Src\CourseDomain\CoachingWeek\Service\CoachingWeeksChecker;
use App\Src\CourseDomain\Course\Event\ChangeCourseEvent;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Service\CourseChanges;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CoachingWeeksController extends Controller
{
    use Breadcrumable, Summarizable;

    private SessionWizardFactory $sessionWizardFactory;

    public function __construct(SessionWizardFactory $sessionWizardFactory)
    {
        $this->sessionWizardFactory = $sessionWizardFactory;
    }

    public function configView(Course $course)
    {
        $form = app(CoachingWeeksForm::class);
        $form->config($course);

        $this->buildCourseSummaryFromCourse($course);

        $this->buildBreadcrumbAndSendToView(CoachingFormBreadcrumb::SLUG);

        view()->share([
            'allowsFullEdition' => $course->allowsFullEdition(user()),
            'course' => $course,
            'form' => $form,
        ]);

        return view('admin.course.coaching-form.coaching_weeks');
    }

    public function save(CoachingWeeksRequest $request, Course $course)
    {
        try {

            if ($course->allowsFullEdition(user())) {

                DB::beginTransaction();

                if ($request->isFlexSelected()) {
                    $course = $this->processFlex($request, $course);
                } else {
                    $course = $this->processWeeks($request, $course);
                }

                DB::commit();
            }

            return redirect()->route('get.admin.course.coaching_form.section_information', $course);

        } catch (StudentsWithSessionsToChangeWeeks $exception) {

            flash($exception->getMessage())->warning();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when save coaching weeks', [
                'course' => $course,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coaching_form.exception.error_general'))->error();

            return back()->withInput();
        }
    }

    private function processFlex(CoachingWeeksRequest $request, Course $course): Course
    {
        $action = app(CourseAsFlexUpdateAction::class);
        $action->handle($course);

        return $course;
    }

    private function processWeeks(CoachingWeeksRequest $request, Course $course): Course
    {
        $beforeCoachingWeeks = $course->coachingWeek;

        $action = app(CourseToWeeksConvertAction::class);
        $course = $action->handle($request, $course);

        $action = app(CourseAsNormalUpdateAction::class);
        $action->handle($course);

        if ($request->hasMakeUpSelected()) {
            $action = app(MakeUpWeekUpdateAction::class);
            $action->handle($request, $course);
        } else {
            $action = app(MakeUpWeekDeleteAction::class);
            $action->handle($course);
        }

        $afterCoachingWeeks = $course->fresh()->coachingWeek;

        $coachigWeeksChecker = app(CoachingWeeksChecker::class);
        $difference = $coachigWeeksChecker->obtainDifference($beforeCoachingWeeks, $afterCoachingWeeks);

        if ($difference->thereAreDifferences()){

            $courseChanges = CourseChanges::buildWithCoachingWeeksDifference($course, $difference);

            event(new ChangeCourseEvent(user(), $courseChanges));
        }

        return $course;
    }
}
