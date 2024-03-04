<?php
namespace App\Src\StudentRole\BookSession\Service\Availability\Algorithm;

use App\Src\CoachDomain\CoachSchedule\Service\DateSlot;
use App\Src\CourseDomain\Course\Model\Course;


class Filter
{

    private Course $course;

    private DateSlot $dateSlot;

    public function __construct (Course $course, DateSlot $dateSlot){
        $this->course = $course;
        $this->dateSlot = $dateSlot;
    }

    public function getCourse(): Course
    {
        return $this->course;
    }

    public function getDateSlot(): DateSlot
    {
        return $this->dateSlot;
    }
}
