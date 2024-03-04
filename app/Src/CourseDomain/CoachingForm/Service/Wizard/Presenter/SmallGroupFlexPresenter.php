<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter;

use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\SmallGroupFlexForm;
use App\Src\CourseDomain\Course\Model\Course;

class SmallGroupFlexPresenter
{
    private SmallGroupFlexForm $smallGroupFlexForm;

    public function __construct(SmallGroupFlexForm $smallGroupFlexForm)
    {

        $this->smallGroupFlexForm = $smallGroupFlexForm;
    }

    public function handle(Course $course): SmallGroupFlexResponse
    {

        $this->smallGroupFlexForm->config($course);

        $response = new SmallGroupFlexResponse($course, $this->smallGroupFlexForm);

        return $response;
    }
}
