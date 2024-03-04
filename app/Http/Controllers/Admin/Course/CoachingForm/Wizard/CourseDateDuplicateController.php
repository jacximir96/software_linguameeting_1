<?php

namespace App\Http\Controllers\Admin\Course\CoachingForm\Wizard;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\CoachingForm\Action\AcademicDatesUpdateAction;
use App\Src\CourseDomain\CoachingForm\Exception\WizardSessionNotExists;
use App\Src\CourseDomain\CoachingForm\Presenter\Breadcrumb\CoachingFormBreadcrumb;
use App\Src\CourseDomain\CoachingForm\Request\AcademicDatesRequest;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\AcademicDatesUpdateForm;
use App\Src\CourseDomain\Course\Model\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Models\SemesterModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CourseDateDuplicateController extends Controller
{
    use Breadcrumable, Summarizable, Sessionable;

    public function configView(Request $request,Course $course)
    {
        $term_activeCourse = $request->term_activeCourse;
        $year_activeCourse = $request->year_activeCourse;
        $startDate_activeCourse = $request->startDate_activeCourse;
        $endDate_activeCourse = $request->endDate_activeCourse;

        try {

            $this->removeCoachingFormInfoSession();

            $form = app(AcademicDatesUpdateForm::class);
            $form->config($course, user());

            $this->buildCourseSummaryFromCourse($course);

            $this->buildBreadcrumbAndSendToView(CoachingFormBreadcrumb::SLUG);

            $semesters = SemesterModel::select('id','name')->get();

            $today = Carbon::now();
            $arrayYears = array($today->year, $today->year + 1);

            view()->share([
                'allowsFullEdition' => $course->allowsFullEdition(user()),
                'hasExperiences' => $course->serviceType->isCombined(),
                'course' => $course,
                'form' => $form,
                'semesters' => $semesters,
                'arrayYears' => $arrayYears,
                'term_activeCourse' => $term_activeCourse,
                'year_activeCourse' => $year_activeCourse,
                'startDate_activeCourse' => $startDate_activeCourse,
                'endDate_activeCourse' => $endDate_activeCourse
            ]);

            return view('admin.course.coaching-form.course_duplicate');
        } catch (WizardSessionNotExists $exception) {
            flash(trans('coaching_form.exception.session_no_exists'))->error();

            return redirect()->route('get.admin.course.coaching_form.create.zero_step');
        }
    }

    public function save(AcademicDatesRequest $request, Course $course)
    {
        try {
            DB::beginTransaction();

            $action = app(AcademicDatesUpdateAction::class);
            $action->handle($request, $course, user());

            DB::commit();

            $request->session()->put('experience_selected', $request->experience);

            return redirect()->route('get.admin.course.coaching_form.update.course_information', $course);
        } catch (\Throwable $exception) {

            Log::error('There is an error when save session academic dates', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coaching_form.exception.step_academic_dates_exception'))->error();

            return back()->withInput();
        }
    }
}
