<?php
namespace App\Http\Controllers\Instructor\Experiences;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\ExperienceDomain\Experience\Presenter\Breadcrumb\Instructor\ListBreadcrumb;
use App\Src\ExperienceDomain\Experience\Repository\ExperienceFilter;
use App\Src\ExperienceDomain\Experience\Repository\ExperienceRepository;
use App\Src\ExperienceDomain\ExperienceRegister\Model\ExperienceRegister;
use App\Src\ExperienceDomain\ExperienceRegister\Repository\ExperienceRegisterRepository;
use App\Src\ExperienceDomain\ExperienceRegister\Service\RegisterList;
use App\Src\Localization\TimeZone\Repository\TimeZoneRepository;
use App\Src\InstructorDomain\Experiences\Presenter\Breadcrumb\Instructor\IndexBreadcrumb;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;


class ListController extends Controller
{
    use Breadcrumable;

    private ExperienceRepository $experienceRepository;

    private CourseRepository $courseRepository;

    private ExperienceRegisterRepository $experienceRegisterRepository;

    public function __construct (ExperienceRepository $experienceRepository, CourseRepository $courseRepository, ExperienceRegisterRepository $experienceRegisterRepository){

        $this->experienceRepository = $experienceRepository;

        $this->courseRepository = $courseRepository;
        $this->experienceRegisterRepository = $experienceRegisterRepository;
    }


    public function __invoke(?string $status = '')
    {

        $instructor = user();

        $nowUTC = Carbon::now($this->userTimezone()->name)->setTimezone('UTC');
        $isUpcoming = false; //upcoming or past

        $filter = $this->obtainFilter($nowUTC, $instructor);

        if ($this->obtainPast($status)){
            $experiences = $this->experienceRepository->obtainPast($filter);
        }
        else{
            $experiences = $this->experienceRepository->obtainUpcoming($filter);
            $isUpcoming = true;
        }

        $breadcrumb = new ListBreadcrumb($isUpcoming);
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $registerList = $this->obtainRegisterList($instructor)->get();

        $registerIds = array();

        foreach ($registerList as $register) {
            $registerIds[] = $register['experience_id']; 
        }
            
        $timezone = TimeZoneRepository::findByName(config('linguameeting.timezone.by_default_in_experiences'));

        view()->share([
            'experiences' => $experiences,
            'registerList' => $registerIds,
            'isUpcoming' => $isUpcoming,
            'mustPayForExperiences' => $instructor->mustPayForExperiences(),
            'instructor' => $instructor,
            'nowUTC' => $nowUTC,
            'timezone' => $timezone,
        ]);

        return view('instructor.experiences.list');
    }

    private function obtainPast (?string $status = ''){
        return $status == 'past';
    }


    private function obtainFilter (Carbon $nowUTC, User $instructor):ExperienceFilter{

        $filter = new ExperienceFilter();
        $filter->addMoment($nowUTC);

        foreach ($instructor->university as $university ){

            $filter->addUniversity($university);

            $courses = $this->courseRepository->obtainCourseFromUniversity($university);

            foreach ($courses as $course){
                if ($course->isActive()){
                    $filter->addCourse($course);
                }
            }

        }

        return $filter;
    }

    private function obtainRegisterList (User $instructor):RegisterList{

        $registerList = new RegisterList();

        $experiencesRegisters = $this->experienceRegisterRepository->obtainByUser($instructor);

        foreach ($experiencesRegisters as $experienceRegister){
            $registerList->add($experienceRegister);
        }

        return $registerList;
    }  
}
