<?php

namespace App\Http\Controllers\Admin\Course\CoachingForm\Wizard;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\CoachingForm\Presenter\Breadcrumb\CoachingFormBreadcrumb;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use Illuminate\Support\Facades\Log;

class CourseSummaryController extends Controller
{
    use Breadcrumable, Summarizable;

    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function __invoke(Course $course)
    {
        try {
            $course->load($this->courseRepository->relationsWithSections());

            $this->buildCourseSummaryFromCourse($course);

            $this->buildBreadcrumbAndSendToView(CoachingFormBreadcrumb::SLUG);

            view()->share([
                'course' => $course,
                'linguaMoney' => new LinguaMoney(),
                'loadExpanderJs' => true,
            ]);

            return view('admin.course.coaching-form.course_summary_step');
        } catch (\Throwable $exception) {
            Log::error('There is an error when show course summary', [
                'course' => $course,
                'exception' => $exception,
            ]);

            flash(trans('coaching_form.exception.error_general'))->error();

            return back();
        }
    }
}
