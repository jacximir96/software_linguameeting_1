<?php
namespace App\Http\Controllers\Instructor\Experiences;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\Experience\Presenter\ShowExperiencePresenter;
use App\Src\ExperienceDomain\Experience\Repository\ExperienceFilter;
use App\Src\ExperienceDomain\Experience\Repository\ExperienceRepository;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;


class ShowController extends Controller
{
    use Breadcrumable;

    private ExperienceRepository $experienceRepository;

    private CourseRepository $courseRepository;

    public function __construct (ExperienceRepository $experienceRepository, CourseRepository $courseRepository){

        $this->experienceRepository = $experienceRepository;

        $this->courseRepository = $courseRepository;
    }


    public function __invoke(Experience $experience, Course $course)
    {
        if ($course->id === null) {
            $instructor = user();

            $presenter = app(ShowExperiencePresenter::class);
            $viewData = $presenter->handle($instructor, $experience);

            view()->share([
                'viewData' => $viewData,
            ]);
        }
        else{
            $instructor = user();

            $presenter = app(ShowExperiencePresenter::class);
            $viewData = $presenter->handle2($instructor, $experience, $course);

            view()->share([
                'viewData' => $viewData,
            ]);
        }
        
        
        
        return view('instructor.experiences.modal_students_experience');
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
}
