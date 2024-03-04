<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Presenter\Instructor;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Repository\CourseInstructorRepository;
use App\Src\CourseDomain\SessionDomain\StudentReview\Model\StudentReview;
use App\Src\CourseDomain\SessionDomain\StudentReview\Repository\StudentReviewRepository;
use App\Src\Shared\Model\ValueObject\Id;
use App\Src\Shared\Service\IdCollection;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;


class StudentsTablePresenter
{
    //construct
    private CourseInstructorRepository $courseInstructorRepository;

    private StudentReviewRepository $studentReviewRepository;

    //status
    private User $instructor;

    private InstructorStudentsFilter $studentsFilter;

    private Collection $instructorCourses;

    private Students $students;

    private GradeStats $gradeStats;

    public function __construct(CourseInstructorRepository $courseInstructorRepository, StudentReviewRepository $studentReviewRepository)
    {
        $this->courseInstructorRepository = $courseInstructorRepository;
        $this->studentReviewRepository = $studentReviewRepository;

        $this->instructorCourses = collect();
        $this->students = new Students();
        $this->gradeStats = new GradeStats();

    }

    public function handle(InstructorStudentsFilter $studentsFilter): StudentsTableResponse
    {

        $this->initialize($studentsFilter);

        $this->configInstructorCourses();

        $this->configStudentData();

        return new StudentsTableResponse($this->students, $this->instructorCourses);
    }

    private function initialize(InstructorStudentsFilter $studentsFilter)
    {
        $this->instructor = $studentsFilter->instructor();
        $this->studentsFilter = $studentsFilter;
    }

    private function configInstructorCourses()
    {
        $instructorCourses = $this->courseInstructorRepository->obtainActivesForInstructor($this->instructor);

        foreach ($instructorCourses as $instructorCourse){

            if ($this->studentsFilter->searchByCourse()){

                if ($this->studentsFilter->hasCourse($instructorCourse)){
                    $this->instructorCourses->put($instructorCourse->id, $instructorCourse);
                }
            }
            else{
                $this->instructorCourses->put($instructorCourse->id, $instructorCourse);
            }
        }
    }

    private function configStudentData()
    {

        $collectionCoursesId = $this->obtainIdCollectionFromCourse($this->instructorCourses);

        $reviews = $this->studentReviewRepository->obtainByCourses($collectionCoursesId);

        foreach ($reviews as $review) {
            if ($review->hasGrade()) {

                if ($this->studentsFilter->searchBySection()){

                    $section = $review->enrollmentSession->enrollment->section;

                    if ($this->studentsFilter->hasSection($section)){

                        if ($this->hasToAddStudentAfterFilterByDate($review)){
                            $this->students->addReview($review);
                        }

                    }
                }
                else{
                    if ($this->hasToAddStudentAfterFilterByDate($review)){
                        $this->students->addReview($review);
                    }
                }
            }
        }
    }

    private function hasToAddStudentAfterFilterByDate (StudentReview $studentReview):bool{

        if ( ! $this->studentsFilter->searchByPeriod()){
            return true;
        }

        return $this->studentsFilter->period()->contains($studentReview->enrollmentSession->day);
    }

    private function obtainIdCollectionFromCourse(Collection $courses): IdCollection
    {

        $idCollection = new IdCollection();
        foreach ($courses as $course) {
            $id = new Id($course->id);
            $idCollection->add($id);
        }

        return $idCollection;
    }
}
