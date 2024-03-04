<?php
namespace App\Src\CourseDomain\Course\Service;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\StudentDomain\Makeup\Model\MakeupNumber;


class CourseMakeup
{
    private Course $course;

    public function __construct (Course $course){

        $this->course = $course;
    }

    public function numberMakeupsForPurchase():MakeupNumber{
        return new MakeupNumber($this->course->number_makeups);
    }
}
