<?php
namespace App\Src\ExperienceDomain\Experience\Presenter;

use App\Src\CourseDomain\Course\Repository\CourseInstructorRepository;
use App\Src\ExperienceDomain\Experience\Repository\ExperienceRepository;
use App\Src\ExperienceDomain\Experience\Service\InstructorSearchForm;
use App\Src\ExperienceDomain\ExperienceRegister\Repository\ExperienceRegisterRepository;
use App\Src\Shared\Model\ValueObject\Id;
use App\Src\Shared\Service\IdCollection;
use App\Src\StudentDomain\Enrollment\Repository\EnrollmentRepository;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardInstructorPresenter
{

    private CourseInstructorRepository $courseInstructorRepository;

    private ExperienceRepository $experienceRepository;

    private ExperienceRegisterRepository $experienceRegisterRepository;

    private EnrollmentRepository $enrollmentRepository;

    public function __construct(CourseInstructorRepository $courseInstructorRepository,
                                ExperienceRepository $experienceRepository,
                                ExperienceRegisterRepository $experienceRegisterRepository,
                                EnrollmentRepository $enrollmentRepository){

        $this->courseInstructorRepository = $courseInstructorRepository;
        $this->experienceRepository = $experienceRepository;
        $this->experienceRegisterRepository = $experienceRegisterRepository;
        $this->enrollmentRepository = $enrollmentRepository;
    }


    public function handle(User $instructor):DashboardInstructorResponse{

        //1º) obtener los cursos del instructor
        $instructorCourses = $this->courseInstructorRepository->obtainActivesForInstructor($instructor);


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
        
        $courses = []; 
        foreach ($experiences as $experience) {
            $result = DB::table('experience_register')
                        ->join('user', 'experience_register.user_id', '=', 'user.id')
                        ->join('enrollment', 'user.id', '=', 'enrollment.student_id')
                        ->join('section', 'enrollment.section_id', '=', 'section.id')
                        ->join('course', 'section.course_id', '=', 'course.id')
                        ->select('course.id', 'course.name')
                        ->where('experience_register.experience_id', '=', $experience->id)
                        ->get();
            
            $courses[] = $result;
        }

        $courses = collect($courses)->flatten()->all();

        //3º) contar el número de estudiantes de cada experiencia por cada curso del instructor.
        $experiencesList = new ExperiencesList();
        $totalAttendances = 0;
        foreach ($experiences as $experience){

            $numStudents = 0;

            foreach ($instructorCourses as $instructorCourse){

                $numRegisters = $this->experienceRegisterRepository->countRegisterByExperienceAndCourse ($experience, $instructorCourse);
                $numStudents += $numRegisters;

                $numAttendances = $this->experienceRegisterRepository->countAttendedByExperienceAndCourse($experience, $instructorCourse);
                $totalAttendances += $numAttendances;
            }

            $itemExperience = new ExperienceItem($experience, $numStudents);

            $experiencesList->addItem($itemExperience);

        }

        $attendedStats = $this->obtainStats($instructorCourses, $totalAttendances);

        return new DashboardInstructorResponse($experiencesList, $instructorCourses, $attendedStats, $courses);
    }

    private function obtainStats (Collection $instructorCourses, int $totalAttendances):AttendedStats{

        $coursesIds = $this->obtainIdCollectionFromCourse($instructorCourses);

        $totalEnrollments = $this->enrollmentRepository->countEnrollmentsByCourses($coursesIds);

        return new AttendedStats($totalAttendances,$totalEnrollments);

    }

    private function obtainIdCollectionFromCourse(Collection $courses):IdCollection{

        $idCollection = new IdCollection();
        foreach ($courses as $course){
            $id = new Id($course->id);
            $idCollection->add($id);
        }

        return $idCollection;
    }
}
