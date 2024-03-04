<?php

namespace App\Http\Controllers\Admin\Course\CoachingForm\Wizard;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\CoachingForm\Action\WizardCreateAction;
use App\Src\CourseDomain\CoachingForm\Presenter\Breadcrumb\CoachingFormBreadcrumb;
use App\Src\CourseDomain\CoachingForm\Request\StartRequest;
use App\Src\CourseDomain\CoachingForm\Service\StartForm;
use App\Src\CourseDomain\Course\Model\Course;
use Illuminate\Support\Facades\Log;

class StartController extends Controller
{
    use Breadcrumable;

    public function configView()
    {

        $form = app(StartForm::class);
        $form->config(user());

        $this->buildBreadcrumbAndSendToView(CoachingFormBreadcrumb::SLUG);

        view()->share([
            'form' => $form,
        ]);

        return view('admin.course.coaching-form.start_step');
    }

    public function create(StartRequest $request)
    {
        try {
            if ($request->isCoachingFormForLiveExperiences()){
                return redirect()->route('get.admin.course.coaching_form_experiences.create.academic_dates', $request->university_id);
            }

            $withExperiences = false;
            if ($request->isCoachingFormForCombined()){
                $withExperiences = true;
            }

            if ($request->filled('course_id')) {
                //es edición. Dependiendo del curso, va a un tipo de edición u otra.
                $course = Course::find($request->course_id);
                if ($course->serviceType->isExperiences()){
                    return redirect()->route('get.admin.course.coaching_form_experiences.create.update.academic_dates', $request->course_id);
                }

                return redirect()->route('get.admin.course.coaching_form.create.update.academic_dates', $request->course_id);
            }

            $action = app(WizardCreateAction::class);
            $action->handle($request, $withExperiences);

            return redirect()->route('get.admin.course.coaching_form.create.academic_dates');
        }
        catch (\Throwable $exception) {

            Log::error('There is an error when save start controller coaching form', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coaching_form.exception.step_academic_dates_exception'))->error();

            return back()->withInput();
        }
    }
}
