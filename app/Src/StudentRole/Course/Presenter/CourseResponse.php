<?php

namespace App\Src\StudentRole\Course\Presenter;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use Illuminate\Support\Collection;

class CourseResponse
{
    private Enrollment $enrollment;

    public function __construct(Enrollment $enrollment)
    {

        $this->enrollment = $enrollment;

    }

    public function enrollment(): Enrollment
    {
        return $this->enrollment;
    }

    public function section(): Section
    {
        return $this->enrollment->section;
    }

    public function course(): Course
    {
        return $this->enrollment->section->course;
    }

    public function session(): Collection
    {
        return $this->enrollment->section->course->session;
    }
}
