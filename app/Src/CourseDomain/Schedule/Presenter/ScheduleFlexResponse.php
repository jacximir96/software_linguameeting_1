<?php

namespace App\Src\CourseDomain\Schedule\Presenter;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Schedule\Service\SearchScheduleForm;
use App\Src\TimeDomain\Date\Service\Periods;

class ScheduleFlexResponse
{
    private Course $course;

    private Periods $weeks;

    private SearchScheduleForm $searchForm;

    private Schedule $schedule;

    public function __construct(Course $course, Periods $periods, SearchScheduleForm $searchForm, Schedule $schedule)
    {

        $this->course = $course;
        $this->weeks = $periods;
        $this->searchForm = $searchForm;
        $this->schedule = $schedule;
    }

    public function course(): Course
    {
        return $this->course;
    }

    public function periods(): Periods
    {
        return $this->weeks;
    }

    public function searchForm(): SearchScheduleForm
    {
        return $this->searchForm;
    }

    public function schedule(): Schedule
    {
        return $this->schedule;
    }
}
