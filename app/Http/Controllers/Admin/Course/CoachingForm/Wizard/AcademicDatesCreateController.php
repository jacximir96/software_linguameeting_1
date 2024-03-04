<?php

namespace App\Http\Controllers\Admin\Course\CoachingForm\Wizard;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\CoachingForm\Action\AcademicDatesAction;
use App\Src\CourseDomain\CoachingForm\Exception\WizardSessionNotExists;
use App\Src\CourseDomain\CoachingForm\Presenter\Breadcrumb\CoachingFormBreadcrumb;
use App\Src\CourseDomain\CoachingForm\Request\AcademicDatesRequest;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\AcademicDatesCreateForm;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\SessionWizardFactory;
use Illuminate\Support\Facades\Log;

class AcademicDatesCreateController extends Controller
{
    use Breadcrumable, Summarizable;

    private SessionWizardFactory $sessionWizardFactory;

    public function __construct(SessionWizardFactory $sessionWizardFactory)
    {
        $this->sessionWizardFactory = $sessionWizardFactory;
    }

    public function configView()
    {
        try {

            $wizard = $this->sessionWizardFactory->buildFromSession();

            $form = app(AcademicDatesCreateForm::class);
            $form->config($wizard);

            $this->buildCourseSummaryFromWizard($wizard);

            $this->buildBreadcrumbAndSendToView(CoachingFormBreadcrumb::SLUG);

            view()->share([
                'allowsFullEdition' => true,
                'hasExperiences' => $wizard->isServiceWithExperiences(),
                'form' => $form,
                'wizard' => $wizard,
            ]);

            return view('admin.course.coaching-form.academic_dates');
        } catch (WizardSessionNotExists $exception) {

            flash(trans('coaching_form.exception.session_no_exists'))->error();

            return redirect()->route('get.admin.course.coaching_form.create.zero_step');
        }
    }

    public function save(AcademicDatesRequest $request)
    {
        try {
            $action = app(AcademicDatesAction::class);
            $action->handle($request);

            return redirect()->route('get.admin.course.coaching_form.create.course_information');
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
