<?php

namespace App\Http\Controllers\Admin\Course\CoachingForm\Wizard;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\CoachingForm\Action\WizardCreateAction;
use App\Src\CourseDomain\CoachingForm\Presenter\Breadcrumb\CoachingFormBreadcrumb;
use App\Src\CourseDomain\CoachingForm\Request\StartRequest;
use App\Src\CourseDomain\CoachingForm\Service\StartForm;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\CourseCoordinator\Model\CourseCoordinator;
use App\Src\CourseDomain\Holiday\Model\Holiday;
use App\Src\CourseDomain\Section\Model\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Src\CourseDomain\Section\Service\SectionCodeGenerator;

class StartController extends Controller
{
    use Breadcrumable;

    private SectionCodeGenerator $sectionCodeGenerator;

    public function __construct(SectionCodeGenerator $sectionCodeGenerator)
    {
        $this->sectionCodeGenerator = $sectionCodeGenerator;
    }

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

    public function duplicate(Request $request){

        $courseOld = Course::find($request->idDuplicate);

        $courseSelected = Course::find($request->idDuplicate);
            $courseSelected = $courseSelected->replicate();
            $courseSelected->semester_id= $request->term_activeCourse;
            $courseSelected->year= $request->year_activeCourse;
            $courseSelected->start_date= $request->startDate_activeCourse;
            $courseSelected->end_date= $request->endDate_activeCourse;
            $courseSelected->save();
        
        $sectionGet = Section::where('course_id', '=', $courseOld->id)->get();
        foreach($sectionGet as $section){
            $sectionModificado = $section->replicate();
            $sectionModificado->course_id = $courseSelected->id;
            $sectionModificado->code = $this->sectionCodeGenerator->generateCode();
            $sectionModificado->save();
        }

        $coachingWeekGet = CoachingWeek::where('course_id', '=', $courseOld->id)->get();
        foreach($coachingWeekGet as $coachingWeek){
            $coachingWeekModificado = $coachingWeek->replicate();
            $coachingWeekModificado->course_id = $courseSelected->id;
            $coachingWeekModificado->save();
        }

        $holidaysGet = Holiday::where('course_id', '=', $courseOld->id)->get();
        foreach($holidaysGet as $holiday){
            $holidayModificado = $holiday->replicate();
            $holidayModificado->course_id = $courseSelected->id;
            $holidayModificado->save();
        }

        return redirect()->route('get.admin.course.coaching_form.create.update.academic_dates', $courseSelected->id);
    }
}
