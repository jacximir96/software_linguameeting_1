<?php

namespace App\Http\Controllers\Admin\Course\CoachingForm\Wizard;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\ConversationPackageDomain\Package\Exception\ConversationPackageNotFound;
use App\Src\CourseDomain\CoachingForm\Action\CourseInformationCreateAction;
use App\Src\CourseDomain\CoachingForm\Exception\WizardSessionNotExists;
use App\Src\CourseDomain\CoachingForm\Request\CourseInformationRequest;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\CourseInformationFromWizardForm;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\SessionWizardFactory;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseInformationCreateController extends Controller
{
    use Breadcrumable, Summarizable;

    private SessionWizardFactory $sessionWizardFactory;

    private CourseRepository $courseRepository;

    public function __construct(SessionWizardFactory $sessionWizardFactory, CourseRepository $courseRepository)
    {
        $this->sessionWizardFactory = $sessionWizardFactory;
        $this->courseRepository = $courseRepository;
    }

    public function configView()
    {
        try {
            $wizard = $this->sessionWizardFactory->buildFromSession();

            $form = app(CourseInformationFromWizardForm::class);
            $form->config($wizard);

            $this->buildCourseSummaryFromWizard($wizard);

            view()->share([
                'form' => $form,
            ]);

            return view('admin.course.coaching-form.course_information');
        } catch (WizardSessionNotExists $exception) {
            flash(trans('coaching_form.exception.session_no_exists'))->error();

            return redirect()->route('get.admin.course.coaching_form.create.zero_step');
        } catch (\Throwable $exception) {
            Log::error('There is an error when show course information view', [
                'exception' => $exception,
            ]);

            flash(trans('coaching_form.exception.error_general'))->error();

            return back();
        }
    }

    public function save(CourseInformationRequest $request)
    {
        try {
            DB::beginTransaction();

            $action = app(CourseInformationCreateAction::class);
            $course = $action->handle($request, user());

            DB::commit();

            return redirect()->route('get.admin.course.coaching_form.coaching_weeks', $course);

        } catch (ConversationPackageNotFound $exception) {

            flash($exception->getMessage())->error();

            return back();

        } catch (\Throwable $exception) {

            Log::error('There is an error when save course information', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coaching_form.exception.error_general'))->error();

            return back()->withInput();
        }
    }
}
