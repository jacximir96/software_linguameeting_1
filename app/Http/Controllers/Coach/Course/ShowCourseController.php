<?php
namespace App\Http\Controllers\Coach\Course;


use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Repository\CourseRepository;


class ShowCourseController extends Controller
{
    private CourseRepository $courseRepository;

    public function __construct (CourseRepository $courseRepository){

        $this->courseRepository = $courseRepository;
    }

    public function __invoke(Course $course)
    {

        $course->load($this->courseRepository->relationsWithSections());

        $coach = user();

        view()->share([
            'loadExpanderJs' => true,
            'coach' => $coach,
            'course' => $course,
        ]);

        if ($course->isFlex()){
            return view('coach.course.show_flex');
        }

        return view('coach.course.show_week');
    }
}
