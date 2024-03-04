<?php
namespace App\Http\Controllers\Instructor\Experiences;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\ExperienceDomain\Experience\Presenter\Breadcrumb\Instructor\DashboardBreadcrumb;
use App\Src\ExperienceDomain\Experience\Presenter\DashboardInstructorPresenter;
use App\Src\ExperienceDomain\Experience\Repository\ExperienceRepository;


class DashboardController extends Controller
{
    use Breadcrumable;

    private ExperienceRepository $experienceRepository;

    private CourseRepository $courseRepository;

    public function __construct (ExperienceRepository $experienceRepository, CourseRepository $courseRepository){

        $this->experienceRepository = $experienceRepository;

        $this->courseRepository = $courseRepository;
    }


    public function __invoke(?string $status = '')
    {

        $instructor = user();

        $presenter = app(DashboardInstructorPresenter::class);
        $viewData = $presenter->handle($instructor);

        $breadcrumb = new DashboardBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'experienceTimezone' => $this->experienceTimezone(),
            'viewData' => $viewData,
        ]);

        return view('instructor.experiences.dashboard');
    }
}
