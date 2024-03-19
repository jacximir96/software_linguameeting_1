<?php
namespace App\Src\ExperienceDomain\Experience\Presenter;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Repository\CourseInstructorRepository;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\Experience\Repository\ExperienceRepository;
use App\Src\ExperienceDomain\ExperienceRegister\Repository\ExperienceRegisterRepository;
use App\Src\UserDomain\User\Model\User;

class ShowExperiencePresenter
{

    private CourseInstructorRepository $courseInstructorRepository;

    private ExperienceRepository $experienceRepository;

    private ExperienceRegisterRepository $experienceRegisterRepository;

    public function __construct(CourseInstructorRepository $courseInstructorRepository, ExperienceRepository $experienceRepository, ExperienceRegisterRepository $experienceRegisterRepository){

        $this->courseInstructorRepository = $courseInstructorRepository;
        $this->experienceRepository = $experienceRepository;
        $this->experienceRegisterRepository = $experienceRegisterRepository;
    }


    public function handle(User $instructor, Experience $experience):ShowExperienceResponse{

        //1º) obtener los cursos del instructor
        $instructorCourses = $this->courseInstructorRepository->obtainActivesForInstructor($instructor);
        $instructorCoursesIds = $instructorCourses->pluck('id')->toArray();

        //2º) obtener estudiantes de la experiencia de los cursos de los instructores
        $studentsList = new StudentsList();

        $processedStudents = []; 

        foreach ($instructorCourses as $instructorCourse) {
            $studentsByCourse = $this->experienceRegisterRepository->registerByExperienceAndCourse($experience, $instructorCourse);
            
            foreach ($studentsByCourse as $studentByCourse) {

                if (in_array($studentByCourse->user->id, $processedStudents)) {
                    continue;
                }

                foreach ($studentByCourse->user->enrollment as $enrollment) {    //este foreach es porque un estudiante puede tener más de una matrícula y nos quedamos con la que realmente es del instructor
                    if (in_array($enrollment->section->course_id, $instructorCoursesIds)) {
                        $item = new StudentItem($studentByCourse->user, $enrollment);
                        $studentsList->addItem($item);

                        $processedStudents[] = $studentByCourse->user->id;
                    }
                }
            }
        }


        return new ShowExperienceResponse($studentsList);
    }

    public function handle2(User $instructor, Experience $experience, Course $course):ShowExperienceResponse{
        
        //1º) obtener los cursos del instructor
        $instructorCourse = $this->courseInstructorRepository->obtainActivesForInstructor($instructor)->where('id', $course->id)->first();
        
        $instructorCoursesIds = $instructorCourse->pluck('id')->toArray();

        //2º) obtener estudiantes de la experiencia de los cursos de los instructores
        $studentsList = new StudentsList();

        $processedStudents = []; 
        
        
            $studentsByCourse = $this->experienceRegisterRepository->registerByExperienceAndCourse($experience, $instructorCourse);
            
            foreach ($studentsByCourse as $studentByCourse) {

                if (in_array($studentByCourse->user->id, $processedStudents)) {
                    continue;
                }
                
                foreach ($studentByCourse->user->enrollment as $enrollment) {    //este foreach es porque un estudiante puede tener más de una matrícula y nos quedamos con la que realmente es del instructor
                    
                    if($enrollment->section->course_id === $course->id){
                        if (in_array($enrollment->section->course_id, $instructorCoursesIds)) {
                            $item = new StudentItem($studentByCourse->user, $enrollment);
                            $studentsList->addItem($item);
                            $processedStudents[] = $studentByCourse->user->id;
                        }
                    }
                    
                }
            }
        


        return new ShowExperienceResponse($studentsList);
    }
}
