<?php

namespace App\Src\CourseDomain\CoachingFormExperiences\Action;

use App\Src\CourseDomain\CoachingFormExperiences\Request\AcademicDatesRequest;
use App\Src\CourseDomain\Course\Event\ChangeCourseEvent;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Service\CourseChanges;
use App\Src\CourseDomain\ServiceType\Model\ServiceType;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\Shared\Service\ColorFactory;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UserDomain\User\Model\User;

class AcademicDatesCreateAction
{
    private LinguaMoney $linguaMoney;

    private ColorFactory $colorFactory;

    public function __construct(LinguaMoney $linguaMoney, ColorFactory $colorFactory)
    {

        $this->linguaMoney = $linguaMoney;
        $this->colorFactory = $colorFactory;
    }

    public function handle(AcademicDatesRequest $request, University $university, User $user): Course
    {

        $course = new Course();
        $course->service_type_id = ServiceType::ID_EXPERIENCES;
        $course->experience_type_id = $request->experience_type_id;
        $course->university_id = $university->id;
        $course->language_id = $request->language_id;
        $course->semester_id = $request->semester_id;
        $course->level_id = 3;
        $course->name = $request->name;
        $course->year = $request->year;
        $course->start_date = $request->start_date;
        $course->end_date = $request->end_date;

        $course->conversation_package_id = null;
        $course->conversation_guide_id = null;
        $course->student_class = 0;
        $course->duration = 0;

        if ($request->hasDiscount()) {
            $course->discount = $this->linguaMoney->buildFromFloat($request->discount);
        }

        $course->is_lingro = $request->is_lingro;
        $course->is_free = $request->is_free;
        $course->is_flex = true;

        $course->buy_makeups = false;
        $course->number_makeups = 0;
        $course->complimentary_makeup = 0;

        $course->color = $this->colorFactory->generateColorRGBA();
        $course->creator_id = $user->id;

        $course->save();

        $courseChanges = new CourseChanges($course);
        event(new ChangeCourseEvent($user, $courseChanges));

        return $course;
    }
}
