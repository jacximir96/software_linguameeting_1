<?php
namespace App\Http\Controllers\Student\Enrollment\Past;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\ExperienceRegister\Model\ExperienceRegister;
use App\Src\ExperienceDomain\ExperienceRegister\Repository\ExperienceRegisterRepository;
use App\Src\Localization\TimeZone\Repository\TimeZoneRepository;
use App\Src\StudentDomain\Enrollment\Repository\EnrollmentRepository;
use App\Src\StudentDomain\Student\Presenter\Breadcrumb\StudentRole\DashboardBreadcrumb;
use App\Src\StudentDomain\Student\Presenter\Breadcrumb\StudentRole\DashboardPastBreadcrumb;
use Carbon\Carbon;


class IndexController extends Controller
{
    use Breadcrumable;

    private EnrollmentRepository $enrollmentRepository;

    public function __construct (EnrollmentRepository $enrollmentRepository){
        $this->enrollmentRepository = $enrollmentRepository;
    }

    public function __invoke()
    {
        $student = user();

        $enrollments = $this->enrollmentRepository->pastForStudent($student);

        $breadcrumb = new DashboardPastBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $nowUTC = Carbon::now($this->userTimezone()->name)->setTimezone('UTC');


        view()->share([
            'enrollments' => $enrollments,
            'nowUTC' => $nowUTC,
            'student' => $student,
            'timezone' => $this->userTimezone(),
        ]);

        return view('student.enrollment.past.index');
    }
}
