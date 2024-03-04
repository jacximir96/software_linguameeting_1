<?php
namespace App\Src\ExperienceDomain\Experience\Repository;


use App\Src\CourseDomain\Course\Model\Course;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ExperienceFilter
{

    private ?Carbon $moment;

    private Collection $universities;

    private Collection $courses;

    private Collection $coaches;

    public function __construct (){
        $this->moment = null;
        $this->universities = collect();
        $this->courses = collect();
        $this->coaches = collect();
    }

    //---query
    public function filterByMoment ():bool{
        return !is_null($this->moment);
    }

    public function filterByUniversities ():bool{
        return (bool)$this->universities->count();
    }

    public function filterByCourses ():bool{
        return (bool)$this->courses->count();
    }

    public function filterByCoaches ():bool{
        return (bool)$this->coaches->count();
    }

    //---adds
    public function addMoment (Carbon $moment){
        $this->moment = $moment;
    }

    public function addUniversity(University $university){
        $this->universities->put($university->id, $university);
    }

    public function addCourse(Course $course){
        $this->courses->put($course->id, $course);
    }

    public function addCoach(User $coaoch){
        $this->universities->put($coaoch->id, $coaoch);
    }


    public function moment ():Carbon{
        return $this->moment;
    }
    //---keys
    public function universitiesKeys ():Collection{
        return $this->universities->keys();
    }

    public function coursesKeys ():Collection{
        return $this->courses->keys();
    }

    public function coachesKeys ():Collection{
        return $this->coaches->keys();
    }
}
