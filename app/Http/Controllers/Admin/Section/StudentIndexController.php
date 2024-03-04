<?php

namespace App\Http\Controllers\Admin\Section;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Admin\Orderable;
use App\Http\Controllers\Controller;


use App\Src\CourseDomain\Section\Model\Section;
use App\Src\StudentDomain\Enrollment\Repository\EnrollmentRepository;

class StudentIndexController extends Controller
{
    use Breadcrumable, Orderable;

    private EnrollmentRepository $enrollmentRepository;

    public function __construct (EnrollmentRepository $enrollmentRepository){

        $this->enrollmentRepository = $enrollmentRepository;
    }

    public function __invoke(Section $section)
    {

        $enrollments = $this->enrollmentRepository->obtainForSectionPaginate($section);
        view()->share([
            'course' => $section,
            'enrollments' => $enrollments,
        ]);

        return view('admin.student.index_course_section');
    }
}
