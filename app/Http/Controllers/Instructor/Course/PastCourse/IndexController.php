<?php
namespace App\Http\Controllers\Instructor\Course\PastCourse;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\UserDomain\Role\Service\RoleChecker;
use App\Src\InstructorDomain\PastCourses\Presenter\Breadcrumb\Instructor\IndexBreadcrumb;
use App\Http\Controllers\Admin\Instructor\Presentable;



class IndexController extends Controller
{
    use Breadcrumable, Presentable;

    private CourseRepository $courseRepository;
    private RoleChecker $checkerRole;

    public function __construct (RoleChecker $checkerRole, CourseRepository $courseRepository){

        $this->courseRepository = $courseRepository;
        $this->checkerRole = $checkerRole;

    }


    public function __invoke(Int $course_id=0)
    {
        $instructor = user();

        $presenter = $this->obtainPresenter($this->checkerRole, $instructor->rol());
        $data = $presenter->handle($instructor, $course_id);
        //dd($data);

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'checkerRole' => $this->checkerRole,
            'data' => $data,
            'courseSelected' => $course_id,
        ]);


        return view('instructor.course.past_course.index');
    }
}
