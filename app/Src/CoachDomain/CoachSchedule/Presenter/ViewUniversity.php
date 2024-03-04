<?php

namespace App\Src\CoachDomain\CoachSchedule\Presenter;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\UniversityDomain\University\Model\University;
use Illuminate\Support\Collection;

class ViewUniversity
{
    private University $university;

    private Collection $courses;

    public function __construct(University $university)
    {

        $this->university = $university;
        $this->courses = collect();
    }

    public function university(): University
    {
        return $this->university;
    }

    public function courses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course)
    {
        $this->courses->push($course);
    }
}
