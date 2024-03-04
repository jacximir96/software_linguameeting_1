<?php

namespace App\Src\CourseDomain\CoachingFormExperiences\Presenter;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use Carbon\Carbon;
use Money\Money;

class CourseSummaryCoursePresenter implements CourseSummary
{
    private Course $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function course(): Course
    {
        return $this->course;
    }

    public function universityName(): string
    {
        return $this->course->university->name;
    }

    public function endDate(): Carbon
    {
        return $this->course->end_date;
    }

    public function hasEndDate(): bool
    {
        return true;
    }

    public function hasStartDate(): bool
    {
        return true;
    }

    public function isCourse(): bool
    {
        return true;
    }

    public function startDate(): Carbon
    {
        return $this->course->start_date;
    }

    public function formatPrice(Money $price): string
    {
        $money = new LinguaMoney();

        return $money->format($price);
    }
}
