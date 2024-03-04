<?php
namespace App\Src\ExperienceDomain\Experience\Presenter;

use Illuminate\Support\Collection;

class InstructorSearchResponse
{

    private ExperiencesList $experiencesList;

    private Collection $activeCourses;

    public function __construct (ExperiencesList $experiencesList, Collection $activeCourses){
        $this->experiencesList = $experiencesList;
        $this->activeCourses = $activeCourses;
    }

    public function experiencesList(): ExperiencesList
    {
        return $this->experiencesList;
    }

    public function activeCourses ():Collection{
        return $this->activeCourses;
    }

    public function activeCoursesSortByName ():Collection{
        return $this->activeCourses->sortBy(function ($course){
            return $course->name;
        });
    }
}
