<?php

namespace App\Http\Controllers\Admin\Course\CoachingFormExperiences\Wizard;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\CoachingFormExperiences\Action\AcademicDatesCreateAction;
use App\Src\CourseDomain\CoachingFormExperiences\Action\AcademicDatesUpdateAction;
use App\Src\CourseDomain\CoachingFormExperiences\Presenter\Breadcrumb\CoachingFormBreadcrumb;
use App\Src\CourseDomain\CoachingFormExperiences\Request\AcademicDatesRequest;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\SessionWizardFactory;
use App\Src\CourseDomain\CoachingFormExperiences\Service\AcademicDatesForm;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\UniversityDomain\University\Model\University;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AcademicDatesUpdateController extends Controller
{
    use Breadcrumable, ExperiencesSummarizable;

    private SessionWizardFactory $sessionWizardFactory;

    public function __construct(SessionWizardFactory $sessionWizardFactory)
    {
        $this->sessionWizardFactory = $sessionWizardFactory;
    }

    public function configView(Course $course)
    {
        try {

            $form = app(AcademicDatesForm::class);
            $form->configForUpdate($course);

            $this->buildCourseSummaryFromCourse($course);

            $this->buildBreadcrumbAndSendToView(CoachingFormBreadcrumb::SLUG);

            view()->share([
                'allowsFullEdition' => true,
                'course' => $course,
                'form' => $form,
            ]);

            return view('admin.course.coaching-form-experiences.academic_dates');

        } catch (\Throwable $exception) {

            flash(trans('coaching_form.exception.session_no_exists'))->error();

            return redirect()->route('get.admin.course.coaching_form.create.zero_step');
        }
    }

    public function update(AcademicDatesRequest $request, Course $course)
    {
        try {

            DB::beginTransaction();

            $action = app(AcademicDatesUpdateAction::class);
            $course = $action->handle($request, $course);

            DB::commit();

            return redirect()->route('get.admin.course.coaching_form_experiences.section_information', $course);

        } catch (\Throwable $exception) {

            Log::error('There is an error when update academic dates in coaching form experiences', [
                'course' => $course,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coaching_form.exception.step_academic_dates_exception'))->error();

            return back()->withInput();
        }
    }
}
