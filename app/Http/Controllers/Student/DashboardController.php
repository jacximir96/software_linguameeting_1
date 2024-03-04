<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\ExperienceRegister\Model\ExperienceRegister;
use App\Src\ExperienceDomain\ExperienceRegister\Repository\ExperienceRegisterRepository;
use App\Src\Localization\TimeZone\Repository\TimeZoneRepository;
use App\Src\StudentDomain\Enrollment\Repository\EnrollmentRepository;
use App\Src\StudentDomain\Student\Presenter\Breadcrumb\StudentRole\DashboardBreadcrumb;
use Carbon\Carbon;


class DashboardController extends Controller
{
    use Breadcrumable;

    private EnrollmentRepository $enrollmentRepository;

    private ExperienceRegisterRepository $experienceRegisterRepository;

    public function __construct (EnrollmentRepository $enrollmentRepository, ExperienceRegisterRepository $experienceRegisterRepository){

        $this->enrollmentRepository = $enrollmentRepository;
        $this->experienceRegisterRepository = $experienceRegisterRepository;
    }

    public function __invoke()
    {
        $student = user();

        $enrollments = $this->enrollmentRepository->activeForStudent($student);

        $experiencesRegisters = $this->experienceRegisterRepository->obtainByUser($student);

        $breadcrumb = new DashboardBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $experienceTimezone = TimeZoneRepository::findByName(config('linguameeting.timezone.by_default_in_experiences'));
        $nowUTC = Carbon::now($this->userTimezone()->name)->setTimezone('UTC');


        view()->share([
            'enrollments' => $enrollments,
            'experiencesRegisters' => $experiencesRegisters,
            'student' => $student,
            'experienceTimezone' => $experienceTimezone,
            'nowUTC' => $nowUTC,
        ]);

        return view('student.dashboard.index');
    }
}
