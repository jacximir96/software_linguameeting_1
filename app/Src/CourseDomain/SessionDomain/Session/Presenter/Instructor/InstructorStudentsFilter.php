<?php
namespace App\Src\CourseDomain\SessionDomain\Session\Presenter\Instructor;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\UserDomain\User\Model\User;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;


class InstructorStudentsFilter
{

    private User $instructor;

    private Collection $courses;
    private Collection $sections;

    private ?CarbonPeriod $period = null;


    public function __construct (User $instructor){

        $this->instructor = $instructor;

        $this->courses = collect();
        $this->sections = collect();
    }

    public function instructor ():User{
        return $this->instructor;
    }

    //getters
    public function courses():Collection{
        return $this->courses;
    }

    public function sections ():Collection{
        return $this->sections;
    }

    public function period():CarbonPeriod{
        return $this->period;
    }

    //setters
    public function addCourse (Course $course){
        $this->courses->put($course->id, $course);
    }

    public function addSection (Section $section){
        $this->sections->put($section->id, $section);
    }

    public function setPeriod (CarbonPeriod $period){
        $this->period = $period;
    }

    //questions
    public function searchByCourse():bool{
        return (bool)$this->courses->count();
    }

    public function searchBySection():bool{
        return (bool)$this->sections->count();
    }

    public function searchByPeriod ():bool{
        return !is_null($this->period);
    }

    public function hasCourse (Course $oneCourse){

        foreach ($this->courses as $course){
            if ($course->isSame($oneCourse)){
                return true;
            }
        }

        return false;
    }

    public function hasSection (Section $oneSection){

        foreach ($this->sections as $section){
            if ($section->isSame($oneSection)){
                return true;
            }
        }

        return false;
    }

}
