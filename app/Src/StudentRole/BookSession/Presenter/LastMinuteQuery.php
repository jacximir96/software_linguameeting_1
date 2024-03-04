<?php
namespace App\Src\StudentRole\BookSession\Presenter;

use App\Src\CourseDomain\Course\Model\Course;
use Carbon\CarbonPeriod;


class LastMinuteQuery
{

    private Course $course;

    private CarbonPeriod $period;

    public function __construct (Course $course, CarbonPeriod $period){

        $this->course = $course;
        $this->period = $period;
    }

    public function getCourse(): Course
    {
        return $this->course;
    }

    public function getPeriod(): CarbonPeriod
    {
        return $this->period;
    }
}
