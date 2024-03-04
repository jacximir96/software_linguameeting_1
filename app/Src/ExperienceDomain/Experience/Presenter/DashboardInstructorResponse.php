<?php
namespace App\Src\ExperienceDomain\Experience\Presenter;

use Illuminate\Support\Collection;

class DashboardInstructorResponse
{

    private ExperiencesList $experiencesList;

    private Collection $activeCourses;

    private AttendedStats $attendedStats;


    public function __construct (ExperiencesList $experiencesList, Collection $activeCourses, AttendedStats $attendedStats){
        $this->experiencesList = $experiencesList;
        $this->activeCourses = $activeCourses;
        $this->attendedStats = $attendedStats;
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

    public function attendedStats(): AttendedStats
    {
        return $this->attendedStats;
    }
}
