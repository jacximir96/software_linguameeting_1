<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Model\Course;

use App\Src\StudentDomain\Enrollment\Repository\EnrollmentRepository;

class StudentIndexController extends Controller
{
    use Breadcrumable, Orderable;

    private EnrollmentRepository $enrollmentRepository;

    public function __construct (EnrollmentRepository $enrollmentRepository){

        $this->enrollmentRepository = $enrollmentRepository;
    }

    public function __invoke(Course $course)
    {

        $enrollments = $this->enrollmentRepository->obtainForCoursePaginate($course);
        view()->share([
            'course' => $course,
            'enrollments' => $enrollments,
        ]);

        return view('admin.student.index_course_section');
    }
}
