<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter;

use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\SmallGroupWeekForm;
use App\Src\CourseDomain\Course\Model\Course;

class SmallGroupWeekPresenter
{
    private SmallGroupWeekForm $smallGroupWeekForm;

    public function __construct(SmallGroupWeekForm $smallGroupWeekForm)
    {

        $this->smallGroupWeekForm = $smallGroupWeekForm;
    }

    public function handle(Course $course): SmallGroupWeekResponse
    {

        $this->smallGroupWeekForm->config($course);

        return new SmallGroupWeekResponse($course, $this->smallGroupWeekForm);

    }
}
