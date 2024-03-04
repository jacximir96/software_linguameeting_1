<?php
namespace App\Src\ExperienceDomain\Experience\Presenter;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Repository\CourseInstructorRepository;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\Experience\Repository\ExperienceRepository;
use App\Src\ExperienceDomain\Experience\Request\InstructorSearchExperienceRequest;
use App\Src\ExperienceDomain\ExperienceRegister\Repository\ExperienceRegisterRepository;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class InstructorSearchPresenter
{

    private CourseInstructorRepository $courseInstructorRepository;

    private ExperienceRepository $experienceRepository;

    private ExperienceRegisterRepository $experienceRegisterRepository;

    public function __construct(CourseInstructorRepository $courseInstructorRepository, ExperienceRepository $experienceRepository, ExperienceRegisterRepository $experienceRegisterRepository){

        $this->courseInstructorRepository = $courseInstructorRepository;
        $this->experienceRepository = $experienceRepository;
        $this->experienceRegisterRepository = $experienceRegisterRepository;
    }


    public function handle(InstructorSearchExperienceRequest $request, User $instructor):InstructorSearchResponse{

        //1º) obtener los cursos del instructor
        if ($request->filled('course_id')){
            $course = Course::find($request->course_id);
            $instructorCourses = collect()->push($course);
        }
        else{
            $instructorCourses = $this->courseInstructorRepository->obtainActivesForInstructor($instructor);
        }

        /*
        if ($request->filled('query')){
            //filtrar cursos por query
            $instructorCourses = $instructorCourses->filter(function ($course) use($request){
                return str_contains(mb_strtolower($course->name), mb_strtolower($request->sanitizeQuery()));
            });
        };
        */

        //2º) obtener experiencias con estudiantes de los cursos del instructor que han asistido
        $experiences = collect();
        foreach ($instructorCourses as $course) {
            $courseExperiences = $this->experienceRepository->obtainWithAttendanceFromCourse($course);

            foreach ($courseExperiences as $courseExperience){

                if ( ! $experiences->has($courseExperience->id)){
                    $experiences->put($courseExperience->id, $courseExperience);
                }
            }
        }

        //3º) contar el número de estudiantes de cada experiencia por cada curso del instructor.
        $experiencesList = new ExperiencesList();

        foreach ($experiences as $experience){

            if ($request->filled('query')){

                $querySanitized = mb_strtolower($request->sanitizeQuery());

                $hasQuery = $this->experienceHasQuery($experience, $querySanitized, $instructorCourses);

                if ( ! $hasQuery){
                    continue; //buscar en la siguiente experiencia
                }
            };

            $numStudents = 0;

            foreach ($instructorCourses as $instructorCourse){

                $numStudentsByCourse = $this->experienceRegisterRepository->countRegisterByExperienceAndCourse ($experience, $instructorCourse);

                $numStudents += $numStudentsByCourse;
            }

            $itemExperience = new ExperienceItem($experience, $numStudents);

            $experiencesList->addItem($itemExperience);

        }

        return new InstructorSearchResponse($experiencesList, $instructorCourses);
    }

    /**
     * busca la query del formularuo en el nombre de la experiencia, nombre del curso o nombre de los estudiantes
     * a la primera coincidencia, return true
     */
    private function experienceHasQuery(Experience $experience, string $querySanitized, Collection $instructorCourses): bool
    {

        if (str_contains(mb_strtolower($experience->title), $querySanitized)) { //buscamos en el título de la experiencia
            return true;
        }

        //sigo buscando...
        foreach ($instructorCourses as $instructorCourse) {

            if (str_contains(mb_strtolower($instructorCourse->name), $querySanitized)) { //buscamos en el título de cada curso
                return true;
            }

            return $this->searchQueryInStudentsNames($experience, $instructorCourse, $querySanitized);
        }

        return false;
    }

    private function searchQueryInStudentsNames(Experience $experience, Course $instructorCourse, string $querySanitized): bool
    {
        //buscamos en el nombre de los inscritos
        $experienceRegisters = $this->experienceRegisterRepository->registerByExperienceAndCourse($experience, $instructorCourse);

        foreach ($experienceRegisters as $experienceRegister) {

            $nameAndLastname = $experienceRegister->user->writeFullNameAndLastName();

            if (str_contains(mb_strtolower($nameAndLastname), $querySanitized)) {
                return true;
            }
        }

        return false;
    }
}
