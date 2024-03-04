<?php

namespace App\Src\CourseDomain\Schedule\Presenter;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Schedule\Service\SearchScheduleForm;
use App\Src\CourseDomain\SessionDomain\Session\Repository\SessionRepository;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\TimeDomain\Date\Service\Period;
use App\Src\TimeDomain\Date\Service\Periods;
use App\Src\TimeDomain\Date\Service\PeriodsBuilder;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class ScheduleWeeksPresenter
{
    //construct
    private PeriodsBuilder $builderPeriods;

    private SessionRepository $sessionRepository;

    //status
    private Course $course;

    private User $user;

    private bool $filterWithoutStudent = false;

    private Schedule $schedule;

    public function __construct(PeriodsBuilder $builderPeriods, SessionRepository $sessionRepository)
    {

        $this->builderPeriods = $builderPeriods;
        $this->sessionRepository = $sessionRepository;
    }

    public function handle(Course $course, User $user, bool $filterWithoutStudent = false, bool $isCreateBook): ScheduleWeeksResponse
    {
        $this->initialize($course, $user, $filterWithoutStudent);

        if ($isCreateBook){
            $periodFromCoachingWeek = $this->builderPeriods->makeupFromCourse($course);
        }
        else{
            $periodFromCoachingWeek = $this->builderPeriods->fromCourse($course);
        }

        $searchForm = app(SearchScheduleForm::class);
        $searchForm->config($course, $periodFromCoachingWeek);

        $this->obtainSchedule($periodFromCoachingWeek);

        return new ScheduleWeeksResponse($course, $periodFromCoachingWeek, $searchForm, $this->schedule);
    }

    private function initialize (Course $course, User $user, bool $filterWithoutStudent = false){

        $this->course = $course;
        $this->user = $user;
        $this->filterWithoutStudent = $filterWithoutStudent;

        $hours = new Hours();
        $this->schedule = new Schedule($hours, $user->timezone->name);
    }

    private function obtainSchedule(Periods $periods)
    {
        foreach ($periods->get() as $period) {

            $sessions = $this->obtainSessions($period);

            foreach ($sessions as $session) {
                $this->schedule->addSession($session);
            }
        }
    }

    private function obtainSessions(Period $period): Collection
    {

        $sessionsFacade = collect();

        $start = Carbon::parse($period->get()->getStartDate()->toDateTimeString(), $this->user->timezone->name);
        $end = Carbon::parse($period->get()->getEndDate()->toDateTimeString(), $this->user->timezone->name);

        $startUtc = $start->clone()->setTimezone(TimeZone::TIMEZONE_UTC);
        $endUtc = $end->clone()->setTimezone(TimeZone::TIMEZONE_UTC);

        $periodUtc = CarbonPeriod::create($startUtc, $endUtc);

        $sessions = $this->sessionRepository->obtainForCourseInPeriod($this->course, $periodUtc);

        foreach ($sessions as $session) {

            if ($this->filterWithoutStudent){
                if ($session->hasStudent($this->user)){
                    continue;
                }
            }

            $sessionFacade = new CalendarSessionFacade($session);

            $sessionsFacade->push($sessionFacade);
        }

        return $sessionsFacade;
    }
}
