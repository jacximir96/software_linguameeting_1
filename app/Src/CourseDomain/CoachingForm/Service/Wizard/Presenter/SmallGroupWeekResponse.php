<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter;

use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\SmallGroupWeekForm;
use App\Src\CourseDomain\Course\Model\Course;

class SmallGroupWeekResponse
{
    private Course $course;

    private SmallGroupWeekForm $smallGroupWeekForm;

    public function __construct(Course $course, SmallGroupWeekForm $smallGroupWeekForm)
    {

        $this->course = $course;
        $this->smallGroupWeekForm = $smallGroupWeekForm;
    }

    public function course(): Course
    {
        return $this->course;
    }

    public function form(): SmallGroupWeekForm
    {
        return $this->smallGroupWeekForm;
    }

    public function hasSectionsToOpen(): bool
    {
        return false;
    }
}
