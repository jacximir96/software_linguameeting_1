<?php

namespace App\Src\CourseDomain\CoachingFormExperiences\Action;

use App\Src\CourseDomain\CoachingFormExperiences\Request\AcademicDatesRequest;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\Shared\Service\ColorFactory;

class AcademicDatesUpdateAction
{
    private LinguaMoney $linguaMoney;

    private ColorFactory $colorFactory;

    public function __construct(LinguaMoney $linguaMoney, ColorFactory $colorFactory)
    {

        $this->linguaMoney = $linguaMoney;
        $this->colorFactory = $colorFactory;
    }

    public function handle(AcademicDatesRequest $request, Course $course): Course
    {

        $course->experience_type_id = $request->experience_type_id;
        $course->name = $request->name;
        $course->semester_id = $request->semester_id;
        $course->year = $request->year;
        $course->start_date = $request->start_date;
        $course->end_date = $request->end_date;
        $course->language_id = $request->language_id;

        $course->discount = null;
        if ($request->hasDiscount()) {
            $course->discount = $this->linguaMoney->buildFromFloat($request->discount);
        }

        $course->is_lingro = $request->is_lingro;
        $course->is_free = $request->is_free;

        $course->save();

        return $course;
    }
}
