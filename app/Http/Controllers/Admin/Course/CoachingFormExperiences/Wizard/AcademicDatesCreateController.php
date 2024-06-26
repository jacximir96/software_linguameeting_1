<?php

namespace App\Http\Controllers\Admin\Course\CoachingFormExperiences\Wizard;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\CoachingFormExperiences\Action\AcademicDatesCreateAction;
use App\Src\CourseDomain\CoachingFormExperiences\Presenter\Breadcrumb\CoachingFormBreadcrumb;
use App\Src\CourseDomain\CoachingFormExperiences\Request\AcademicDatesRequest;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\SessionWizardFactory;
use App\Src\CourseDomain\CoachingFormExperiences\Service\AcademicDatesForm;
use App\Src\UniversityDomain\University\Model\University;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AcademicDatesCreateController extends Controller
{
    use Breadcrumable, ExperiencesSummarizable;

    private SessionWizardFactory $sessionWizardFactory;

    public function __construct(SessionWizardFactory $sessionWizardFactory)
    {
        $this->sessionWizardFactory = $sessionWizardFactory;
    }

    public function configView(University $university)
    {
        try {

            $form = app(AcademicDatesForm::class);
            $form->configForCreate($university);

            $this->buildCourseSummaryFromUniversity($university);

            $this->buildBreadcrumbAndSendToView(CoachingFormBreadcrumb::SLUG);

            view()->share([
                'allowsFullEdition' => true,
                'form' => $form,
            ]);

            return view('admin.course.coaching-form-experiences.academic_dates');

        } catch (\Throwable $exception) {

            flash(trans('coaching_form.exception.session_no_exists'))->error();

            return redirect()->route('get.admin.course.coaching_form.create.zero_step');
        }
    }

    public function create(AcademicDatesRequest $request, University $university)
    {
        try {

            DB::beginTransaction();

            $action = app(AcademicDatesCreateAction::class);
            $course = $action->handle($request, $university, user());

            DB::commit();

            return redirect()->route('get.admin.course.coaching_form_experiences.section_information', $course);

        } catch (\Throwable $exception) {

            Log::error('There is an error when create academic dates in coaching form experiences', [
                'university' => $university,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coaching_form.exception.step_academic_dates_exception'))->error();

            return back()->withInput();
        }
    }
}
