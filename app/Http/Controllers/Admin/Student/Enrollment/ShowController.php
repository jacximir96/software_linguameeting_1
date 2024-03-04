<?php

namespace App\Http\Controllers\Admin\Student\Enrollment;

use App\Http\Controllers\Controller;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Enrollment\Presenter\EnrollmentPresenter;
use App\Src\StudentDomain\Enrollment\Repository\EnrollmentRepository;


class ShowController extends Controller
{

    private EnrollmentRepository $enrollmentRepository;

    public function __construct (EnrollmentRepository $enrollmentRepository){

        $this->enrollmentRepository = $enrollmentRepository;
    }

    public function __invoke(Enrollment $enrollment)
    {

        $enrollment->load($this->enrollmentRepository->relationshipsWithSession());

        $query = app(EnrollmentPresenter::class);
        $viewData = $query->handle($enrollment);

        view()->share([
            'enrollment' => $enrollment,
            'viewData' => $viewData,
            'timezone' => $this->userTimezone(),
        ]);

        return view('admin.student.enrollment.show');
    }
}
