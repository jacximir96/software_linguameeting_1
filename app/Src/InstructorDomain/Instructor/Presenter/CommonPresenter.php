<?php

namespace App\Src\InstructorDomain\Instructor\Presenter;

use App\Src\ActivityLog\Model\Activity;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\InstructorDomain\Instructor\Repository\InstructorRepository;
use App\Src\UserDomain\Role\Service\RoleChecker;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;


class CommonPresenter
{
    private InstructorRepository $instructorRepository;

    private CourseRepository $courseRepository;

    private RoleChecker $checkerRole;

    public function __construct(InstructorRepository $instructorRepository, CourseRepository $courseRepository, RoleChecker $checkerRole)
    {
        $this->instructorRepository = $instructorRepository;
        $this->courseRepository = $courseRepository;
        $this->checkerRole = $checkerRole;
    }

    public function handle(User $instructor, Int $course_id=0): CommonResponse
    {
        $instructor->load($this->instructorRepository->relations());

        $courses = $this->courseRepository->obtainCoursesForASectionInstructor($instructor);
        
        if(!empty($course_id)){
            $selected_course = $this->courseRepository->obtainByIds((array)$course_id);
            $activeSections = $this->obtainActiveSections($selected_course);
        }else{
            $activeSections = $this->obtainActiveSections($courses);
        }        

        $activity = $this->obtainActivity($instructor);

        $hasToShowUniversityName = $this->hasToShowUniversityName($instructor);

        return new CommonResponse($instructor, $activeSections, $activity, $hasToShowUniversityName, $courses);
    }

    private function obtainActiveSections(Collection $courses): Collection
    {
        $activeSections = collect();

        foreach ($courses as $course) {     
            
            foreach ($course->section as $section) {
                $activeSections->push($section);
            }
        }

        return $activeSections;
    }

    private function obtainActivity(User $instructor, int $numItems = 5): Collection
    {

        return Activity::causedBy($instructor)->orderBy('id', 'desc')->limit($numItems)->get();

    }

    public function hasToShowUniversityName(User $instructor): bool
    {
        return (bool) $instructor->university->count();
    }
}
