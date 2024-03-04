<?php

namespace App\Http\Controllers\Api\Options\Section;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SessionDomain\Session\Presenter\Instructor\StudentsTablePresenter;
use App\Src\CourseDomain\SessionDomain\Session\Request\FilterStudentsByCourseRequest;


class PrintStudentsTableFilberTyCourseController extends Controller
{

    public function __invoke(FilterStudentsByCourseRequest $request)
    {

        $studentFilter = $request->studentsFilter();

        $presenter = app(StudentsTablePresenter::class);
        $viewData = $presenter->handle($studentFilter);

        $students = $viewData->students()->get();

        view()->share([
            'instructor' => user(),
            'maxSessions' => $viewData->students()->maxSessions(),
            'students' => $students,
        ]);

        return view('instructor.course.gradebook.students_table');
    }
}
