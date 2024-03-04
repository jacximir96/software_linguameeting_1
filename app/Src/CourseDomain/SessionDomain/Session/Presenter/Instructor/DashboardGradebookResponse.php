<?php
namespace App\Src\CourseDomain\SessionDomain\Session\Presenter\Instructor;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\SessionDomain\StudentReviewType\Service\InstructorRubric;
use Illuminate\Support\Collection;

class DashboardGradebookResponse
{

    private InstructorRubric $rubric;

    private GradeStats $gradeStats;

    private Students $students;

    private Collection $courses;

    public function __construct(InstructorRubric $rubric, GradeStats $gradeStats, Students $students, Collection $courses){

        $this->rubric = $rubric;
        $this->gradeStats = $gradeStats;
        $this->students = $students;
        $this->courses = $courses;
    }

    public function rubric(): InstructorRubric
    {
        return $this->rubric;
    }

    public function gradeStats(): GradeStats
    {
        return $this->gradeStats;
    }

    public function students(): Students
    {
        return $this->students;
    }

    public function courses ():Collection{
        return $this->courses;
    }

    public function coursesOptions() :array{

        $options = [];

        foreach ($this->courses as $course){

            $options[$course->id] = $course->name;
        }

        return $options;
    }

    public function sectionsSorted (Course $course):Collection{

        return $course->section->sortBy(function ($section){
            return $section->name;
        });

    }

    public function numMaxOfSessions ():int{

        $numSessions = 1;

        foreach ($this->courses as $course){

            $sessionNumber = $course->conversationPackage->obtainSessionSetup()->sessionNumber()->get();

            if ( $sessionNumber > $numSessions){
                $numSessions = $sessionNumber;
            }
        }

        return $numSessions;

    }

}
