<?php

namespace App\Src\StudentRole\BookSession\Service;

use App\Src\CourseDomain\CoachingWeek\Repository\CoachingWeekRepository;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentRole\BookSession\Request\BookSessionRequest;
use Carbon\Carbon;

class SearchCoachForm extends BaseSearchForm
{
    //construct
    private FieldFormBuilder $fieldFormBuilder;

    private CoachingWeekRepository $coachingWeekRepository;

    //status
    private array $timeOptions;

    private Carbon $minDate;

    private Carbon $maxDate;

    public function __construct(FieldFormBuilder $fieldFormBuilder, CoachingWeekRepository $coachingWeekRepository)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->coachingWeekRepository = $coachingWeekRepository;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function minDate(): Carbon
    {
        return $this->minDate;
    }

    public function maxDate(): Carbon
    {
        return $this->maxDate;
    }

    public function configForSelectView(Enrollment $enrollment, SessionOrder $sessionOrder)
    {
        $this->action = route('post.student.session.book.create.search_coach', [$enrollment->id, $sessionOrder->get()]);

        $this->model = request()->all();

        $this->configOptions();

        $this->configLimitDates($enrollment, $sessionOrder);
    }

    private function configOptions()
    {
        $this->timeOptions = $this->fieldFormBuilder->obtainTimeOptions();
    }

    private function configLimitDates(Enrollment $enrollment, SessionOrder $sessionOrder)
    {

        $course = $enrollment->section->course;

        if ($course->isFlex()) {
            $this->configLimitDatesForFlex($course);
        } else {
            $this->configLimitDatesForWeeks($course, $sessionOrder);
        }
    }

    private function configLimitDatesForFlex(Course $course)
    {

        $this->minDate = $course->start_date;
        $this->maxDate = $course->end_date;

    }

    private function configLimitDatesForWeeks(Course $course, SessionOrder $sessionOrder)
    {

        $coachingWeek = $this->coachingWeekRepository->obtainByCourseAndOrder($course, $sessionOrder->get());

        $this->minDate = $coachingWeek->start_date;
        $this->maxDate = $coachingWeek->end_date;
    }
}
