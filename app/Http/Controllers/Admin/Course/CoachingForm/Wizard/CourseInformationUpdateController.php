<?php

namespace App\Http\Controllers\Admin\Course\CoachingForm\Wizard;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\ConversationPackageDomain\Package\Exception\ConversationPackageNotFound;
use App\Src\CourseDomain\CoachingForm\Action\CourseInformationUpdateAction;
use App\Src\CourseDomain\CoachingForm\Exception\WizardSessionNotExists;
use App\Src\CourseDomain\CoachingForm\Presenter\Breadcrumb\CoachingFormBreadcrumb;
use App\Src\CourseDomain\CoachingForm\Request\CourseInformationRequest;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\CourseInformationFromCourseForm;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseInformationUpdateController extends Controller
{
    use Breadcrumable, Summarizable, Sessionable;

    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function configView(Course $course)
    {
        try {
            $course->load($this->courseRepository->relations());

            $form = app(CourseInformationFromCourseForm::class);
            $form->config($course, user());

            $this->buildCourseSummaryFromCourse($course);

            $this->buildBreadcrumbAndSendToView(CoachingFormBreadcrumb::SLUG);

            view()->share([
                'course' => $course,
                'form' => $form,
            ]);

            return view('admin.course.coaching-form.course_information');
        } catch (WizardSessionNotExists $exception) {
            flash(trans('coaching_form.exception.session_no_exists'))->error();

            return redirect()->route('get.admin.course.coaching_form.create.zero_step');
        } catch (\Throwable $exception) {

            Log::error('There is an error when show update course information form', [
                'course' => $course,
                'exception' => $exception,
            ]);

            flash(trans('section.error.on_create'))->error();

            return back();
        }
    }

    public function save(CourseInformationRequest $request, Course $course)
    {
        try {
            DB::beginTransaction();

            if (session()->has('experience_selected')) {
                $experienceSelected = (bool) session()->get('experience_selected');
                $request->setExperienceSelectedInPrevStep($experienceSelected);
            }

            $action = app(CourseInformationUpdateAction::class);
            $course = $action->handle($request, $course, user());

            DB::commit();

            $this->removeCoachingFormInfoSession();

            return redirect()->route('get.admin.course.coaching_form.coaching_weeks', $course);

        } catch (ConversationPackageNotFound $exception) {

            flash($exception->getMessage())->error();

            return back();

        } catch (\Throwable $exception) {

            Log::error('There is an error when update course information.', [
                'course' => $course,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coaching_form.exception.error_general'))->error();

            return back()->withInput();
        }
    }
}
