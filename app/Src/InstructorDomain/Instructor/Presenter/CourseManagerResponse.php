<?php

namespace App\Src\InstructorDomain\Instructor\Presenter;

use Illuminate\Support\Collection;

class CourseManagerResponse
{
    private CommonResponse $commonResponse;

    private Collection $courses;

    public function __construct(CommonResponse $commonResponse, Collection $courses)
    {
        $this->commonResponse = $commonResponse;
        $this->courses = $courses;
    }

    public function commonResponse(): CommonResponse
    {
        return $this->commonResponse;
    }

    public function courses(): Collection
    {
        return $this->courses;
    }

    public function hasCourses(): bool
    {
        return (bool) $this->courses->count();
    }
}
