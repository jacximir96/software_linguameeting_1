<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter;

use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\SmallGroupFlexForm;
use App\Src\CourseDomain\Course\Model\Course;

class SmallGroupFlexResponse
{
    private Course $course;

    private SmallGroupFlexForm $smallGroupFlexForm;

    public function __construct(Course $course, SmallGroupFlexForm $smallGroupFlexForm)
    {

        $this->course = $course;
        $this->smallGroupFlexForm = $smallGroupFlexForm;
    }

    public function course(): Course
    {
        return $this->course;
    }

    public function form(): SmallGroupFlexForm
    {
        return $this->smallGroupFlexForm;
    }

    public function hasSectionsToOpen(): bool
    {
        return false;
    }
}
