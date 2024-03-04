<?php
namespace App\Src\CourseDomain\Course\Repository;


use App\Src\CourseDomain\Course\Model\Course;
use App\Src\UserDomain\User\Model\User;

class CourseInstructorRepository
{

    private CourseRepository $courseRepository;

    public function __construct (CourseRepository $courseRepository){

        $this->courseRepository = $courseRepository;
    }

    //cursos de todas las universidades del instructor, que estén activos y no tenga el acceso vetado.
    //cursos como coordinator
    public function obtainActivesForInstructor (User $instructor){

        $universities = $instructor->university;
        $languages = $instructor->language;

        $courses = Course::query()
            ->whereIn('university_id', $universities->pluck('id')->toArray())
            ->whereDoesntHave('denyAccess', function ($query) use($instructor){
                $query->where('user_id', $instructor->id);
            });

        if ($languages->count()){
            $courses->whereIn('language_id', $languages->pluck('id')->toArray());
        }

        $courses = $courses->get();

        $courseFiltered = $courses->filter(function ($course){
            if ($course->isActive()){
                return $course;
            }
        });

        $coursesAsCoordinator = Course::query()
            ->wherehas('coordinator', function ($query) use ($instructor){
                $query->where('coordinator_id', $instructor->id);
            })
            ->whereNotIn('id', $courseFiltered->pluck('id', 'id')->toArray())
            ->get();

        $coursesAsCoordinatorFiltered = $coursesAsCoordinator->filter(function ($course){
            if ($course->isActive()){
                return $course;
            }
        });

        return  $courseFiltered->merge($coursesAsCoordinatorFiltered);
    }
}
