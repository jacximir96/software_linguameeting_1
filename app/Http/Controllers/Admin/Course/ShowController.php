<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;

class ShowController extends Controller
{
    use Breadcrumable;

    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function __invoke(Course $course)
    {

        $this->buildBreadcrumbAndSendToView(\App\Src\CourseDomain\Course\Presenter\Breadcrumb\ShowBreadcrumb::SLUG);

        $course->load($this->courseRepository->relationsWithSections());

        $linguaMoney = app(LinguaMoney::class);

        view()->share([
            'course' => $course,
            'experienceTimezone' => $this->experienceTimezone(),
            'linguaMoney' => $linguaMoney,
            'timezone' => $this->userTimezone(),
        ]);

        if ($course->serviceType->isExperiences()){
            return view('admin.course.show_experiences');
        }
        return view('admin.course.show');
    }
}
