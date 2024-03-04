<?php

namespace App\Src\InstructorDomain\Instructor\Presenter;

use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class CommonResponse
{
    private User $instructor;

    private Collection $sections;

    private Collection $activity;

    private Collection $courses;

    private bool $hasToShowUniversityName;

    public function __construct(User $instructor, Collection $sections, Collection $activity, bool $hasToShowUniversityName, Collection $courses)
    {
        $this->instructor = $instructor;
        $this->sections = $sections;
        $this->activity = $activity;
        $this->courses = $courses;
        $this->hasToShowUniversityName = $hasToShowUniversityName;
    }

    public function instructor(): User
    {
        return $this->instructor;
    }

    public function sections(): Collection
    {
        return $this->sections;
    }

    public function courses(): Collection
    {
        return $this->courses;
    }

    public function hasCourses(): bool
    {
        return (bool) $this->courses->count();
    }

    public function hasSections(): bool
    {
        return (bool) $this->sections->count();
    }

    public function activity(): Collection
    {
        return $this->activity;
    }

    public function hasToShowUniversityName(): bool
    {
        return $this->hasToShowUniversityName;
    }

    public function activeCourses ():Collection{

        return $this->courses->filter (function ($course){
            if ($course->isActive()){
                return $course;
            }
        });

    }

    public function pastCourses ():Collection{

        return $this->courses->filter (function ($course){

            if ( ! $course->isActive()){
                return $course;
            }

        });

    }
}
