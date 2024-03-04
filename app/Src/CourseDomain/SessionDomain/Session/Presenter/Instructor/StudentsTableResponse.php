<?php
namespace App\Src\CourseDomain\SessionDomain\Session\Presenter\Instructor;

use App\Src\CourseDomain\SessionDomain\StudentReviewType\Service\InstructorRubric;
use Illuminate\Support\Collection;

class StudentsTableResponse
{
    private Students $students;

    private Collection $courses;

    public function __construct(Students $students, Collection $courses){

        $this->students = $students;
        $this->courses = $courses;
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



}
