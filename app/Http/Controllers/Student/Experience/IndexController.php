<?php
namespace App\Http\Controllers\Student\Experience;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Experience\Repository\ExperienceRepository;
use App\Src\ExperienceDomain\Experience\Repository\ExperienceFilter;
use App\Src\Localization\TimeZone\Repository\TimeZoneRepository;
use App\Src\StudentDomain\Enrollment\Repository\EnrollmentRepository;
use App\Src\StudentDomain\StudentHelp\Repository\StudentHelpRepository;
use App\Src\ExperienceDomain\Experience\Presenter\Breadcrumb\Student\IndexBreadcrumb;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;


class IndexController extends Controller
{
    use Breadcrumable;

    private StudentHelpRepository $coachHelpRepository;

    private ExperienceRepository $experienceRepository;

    private EnrollmentRepository $enrollmentRepository;

    public function __construct (StudentHelpRepository $coachHelpRepository, ExperienceRepository $experienceRepository, EnrollmentRepository $enrollmentRepository){
        $this->coachHelpRepository = $coachHelpRepository;
        $this->experienceRepository = $experienceRepository;
        $this->enrollmentRepository = $enrollmentRepository;
    }


    public function __invoke(?string $status = '')
    {
        $student = user();

        $nowUTC = Carbon::now($this->userTimezone()->name)->setTimezone('UTC');
        $isUpcoming = false; //upcoming or past

        $filter = $this->obtainFilter($nowUTC, $student);

        if ($this->obtainPast($status)){
            $experiences = $this->experienceRepository->obtainPast($filter);
        }
        else{
            $experiences = $this->experienceRepository->obtainUpcoming($filter);
            $isUpcoming = true;
        }

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $timezone = TimeZoneRepository::findByName(config('linguameeting.timezone.by_default_in_experiences'));

        view()->share([
            'experiences' => $experiences,
            'isUpcoming' => $isUpcoming,
            'mustPayForExperiences' => $student->mustPayForExperiences(),
            'student' => $student,
            'nowUTC' => $nowUTC,
            'timezone' => $timezone,
        ]);

        return view('student.experience.index');
    }

    private function obtainPast (?string $status = ''){
        return $status == 'past';
    }

    private function obtainFilter (Carbon $nowUTC, User $student):ExperienceFilter{

        $filter = new ExperienceFilter();
        $filter->addMoment($nowUTC);

        $activesEnrollments = $this->enrollmentRepository->activeForStudent($student);

        foreach ($activesEnrollments as $activeEnrollment){
            $filter->addCourse($activeEnrollment->course());
            $filter->addUniversity($activeEnrollment->course()->university);
        }

        return $filter;
    }
}
