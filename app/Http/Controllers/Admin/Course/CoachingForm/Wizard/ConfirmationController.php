<?php

namespace App\Http\Controllers\Admin\Course\CoachingForm\Wizard;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\CoachingForm\Presenter\Breadcrumb\CoachingFormBreadcrumb;
use App\Src\CourseDomain\CoachingForm\Presenter\CourseSummaryCoursePresenter;
use App\Src\CourseDomain\Course\Action\SendSummaryAction;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Presenter\SummaryFilePresenter;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class ConfirmationController extends Controller
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

            //return $this->test($course);

            $this->buildBreadcrumbAndSendToView(CoachingFormBreadcrumb::SLUG);

            $action = app(SendSummaryAction::class);
            $action->handle($course, user());

            view()->share([
                'course' => $course,
            ]);

            return view('admin.course.coaching-form.confirmation');
        } catch (\Throwable $exception) {

            Log::error('There is an error in confirmation step', [
                'course' => $course,
                'exception' => $exception,
            ]);

            flash(trans('coaching_form.exception.error_general'))->error();

            return back();
        }
    }

    public function test (Course $course){
        try{

            $presenter = app(SummaryFilePresenter::class);
            $viewData = $presenter->handle($course);
            $courseSummary = app(CourseSummaryCoursePresenter::class, ['course' => $course]);

            $data = [
                'courseSummary' => $courseSummary,
                'viewData' => $viewData,
                'linguaMoney' => new LinguaMoney(),
                'user' => user(),
            ];
            view()->share($data);

            return view('admin.course.file.summary.index');

            $pdf = PDF::loadView('admin.course.file.summary.index', $data);

            return $pdf->download();

        }
        catch (\Throwable $exception){


        }

    }
}
