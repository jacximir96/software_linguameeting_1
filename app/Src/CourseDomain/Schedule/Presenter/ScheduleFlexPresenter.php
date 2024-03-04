<?php

namespace App\Src\CourseDomain\Schedule\Presenter;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Schedule\Service\SearchScheduleForm;
use App\Src\CourseDomain\SessionDomain\Session\Repository\SessionRepository;
use App\Src\TimeDomain\Date\Service\Period;
use App\Src\TimeDomain\Date\Service\Periods;
use App\Src\TimeDomain\Date\Service\PeriodsBuilder;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class ScheduleFlexPresenter
{
    //construct
    private PeriodsBuilder $builderPeriods;

    private SessionRepository $sessionRepository;

    //status
    private Course $course;

    private User $user;

    public function __construct(PeriodsBuilder $builderPeriods, SessionRepository $sessionRepository)
    {

        $this->builderPeriods = $builderPeriods;
        $this->sessionRepository = $sessionRepository;
    }

    public function handle(Course $course, User $user): ScheduleFlexResponse
    {

        $this->course = $course;
        $this->user = $user;

        $periods = $this->builderPeriods->fromPeriod($course->period());

        $schedule = $this->obtainSchedule($periods);

        $searchForm = app(SearchScheduleForm::class);
        $searchForm->config($course, $periods);

        return new ScheduleFlexResponse($course, $periods, $searchForm, $schedule);
    }

    private function obtainSchedule(Periods $periods): Schedule
    {

        $schedule = app(Schedule::class);

        foreach ($periods->get() as $period) {

            $sessions = $this->obtainSessions($period);

            foreach ($sessions as $session) {
                $schedule->addSession($session);
            }
        }

        return $schedule;
    }

    private function obtainSessions(Period $period): Collection
    {

        $sessionsFacade = collect();

        $sessions = $this->sessionRepository->obtainForCourseInPeriod($this->course, $period->get());

        foreach ($sessions as $session) {

            $sessionFacade = new CalendarSessionFacade($session);

            $sessionsFacade->push($sessionFacade);
        }

        return $sessionsFacade;
    }
}
