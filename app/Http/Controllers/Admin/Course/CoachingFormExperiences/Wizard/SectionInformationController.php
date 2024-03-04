<?php

namespace App\Http\Controllers\Admin\Course\CoachingFormExperiences\Wizard;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Course\CoachingForm\Wizard\Summarizable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\CoachingFormExperiences\Request\SectionInformationRequest;
use App\Src\CourseDomain\CoachingFormExperiences\Service\SectionInformationForm;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter\SectionInformationPresenter;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SectionInformationController extends Controller
{
    use Breadcrumable, Summarizable;

    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function configView(Course $course)
    {
        try {
            $course->load($this->courseRepository->relationsWithSections());

            $sectionInformationForm = app(SectionInformationForm::class);
            $sectionInformationForm->config($course, user());

            $presenter = app(SectionInformationPresenter::class);
            $sectionInformationResponse = $presenter->handle($course);

            $this->buildCourseSummaryFromCourse($course);

            $this->buildBreadcrumbAndSendToView(\App\Src\CourseDomain\CoachingFormExperiences\Presenter\Breadcrumb\CoachingFormBreadcrumb::SLUG);

            view()->share([
                'allowsFullEdition' => true,
                'course' => $course,
                'sectionInformationForm' => $sectionInformationForm,
                'viewData' => $sectionInformationResponse,
            ]);

            return view('admin.course.coaching-form-experiences.section_information');
        } catch (\Throwable $exception) {

            Log::error('There is an error when show form section information step', [
                'course' => $course,
                'exception' => $exception,
            ]);

            flash(trans('coaching_form.exception.step_section_information_exception'))->error();

            return back()->withInput();
        }
    }

    public function save(SectionInformationRequest $request, Course $course)
    {
        try {

            return redirect()->route('get.admin.course.coaching_form_experiences.course_summary', $course);



        } catch (ValidationException $exception) {

            return back();
        } catch (\Throwable $exception) {

            Log::error('There is an error when save section information step', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coaching_form.exception.step_section_information_exception'))->error();

            return back()->withInput();
        }
    }
}
