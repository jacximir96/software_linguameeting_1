<?php

namespace App\Src\InstructorDomain\Instructor\Presenter;

use Illuminate\Support\Collection;

class InstructorResponse
{
    private CommonResponse $commonResponse;

    private Collection $courses;

    private Collection $pastCourses;

    public function __construct(CommonResponse $commonResponse, Collection $courses, Collection $pastCourses)
    {
        $this->commonResponse = $commonResponse;
        $this->courses = $courses;
        $this->pastCourses = $pastCourses;
    }

    public function commonResponse(): CommonResponse
    {
        return $this->commonResponse;
    }

    public function courses(): Collection
    {
        return $this->courses;
    }

    public function pastCourses(): Collection
    {
        return $this->pastCourses;
    }

    public function hasCourses(): bool
    {
        return (bool) $this->courses->count();
    }
}
