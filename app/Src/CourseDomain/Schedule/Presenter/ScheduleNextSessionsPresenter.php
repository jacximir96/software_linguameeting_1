<?php
namespace App\Src\CourseDomain\Schedule\Presenter;

use App\Src\CoachDomain\CoachSchedule\Repository\CoachScheduleRepository;
use App\Src\CoachDomain\CoachSchedule\Service\DateSlot;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Repository\SessionRepository;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\TimeDomain\Date\Service\Period;
use App\Src\TimeDomain\Date\Service\Periods;
use App\Src\TimeDomain\Date\Service\PeriodsBuilder;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;


class ScheduleNextSessionsPresenter
{
    //construct
    private PeriodsBuilder $builderPeriods;

    private SessionRepository $sessionRepository;

    private CoachScheduleRepository $coachScheduleRepository;


    //status
    private Session $session;

    private Schedule $schedule;


    public function __construct(PeriodsBuilder $builderPeriods, SessionRepository $sessionRepository, CoachScheduleRepository $coachScheduleRepository)
    {

        $this->builderPeriods = $builderPeriods;
        $this->sessionRepository = $sessionRepository;
        $this->coachScheduleRepository = $coachScheduleRepository;
    }

    public function handle(Session $session){

        $this->initialize($session);

        $periodFromCoachingWeek = $this->builderPeriods->fromCourse($session->course);

        $nextCoachingWeeks = $periodFromCoachingWeek->nextPeriods($session->day);

        $this->obtainSchedule($nextCoachingWeeks);

        dd($periodFromCoachingWeek, $nextCoachingWeeks, 'next');

    }

    private function initialize (Session $session){

        $this->session = $session;

        $hours = new Hours();
        $this->schedule = new Schedule($hours);
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

        $availability = collect();

        $carbonPeriod = $period->get();

        foreach ($carbonPeriod as $carbonDay){

            if ($carbonDay->weekday() == $this->session->day->weekDay()){

                $start = Carbon::parse($carbonDay->toDateString().' '.$this->session->start_time);
                $end = Carbon::parse($carbonDay->toDateString().' '.$this->session->end_time);  //restamos minuto para evitar resultados 'erróneos' con el fin del día

                $dateSlot = new DateSlot($start, $end);

                $availability = $this->coachScheduleRepository->obtainAvailabilityForCoachAndSlot($this->session->coach, $dateSlot);


                dd($dateSlot, $availability, $this->session->coach);
            }

        }

        dd($carbonPeriod);

        $start = $period->get()->getStartDate();
        $end = $period->get()->getEndDate();

        $dateSlot = $this->session->dateSlot();

        dd($dateSlot, 'dateSlot');

        $periodUtc = CarbonPeriod::create($start, $end);

        $sessions = $this->sessionRepository->obtainForCourseInPeriod($this->session->course, $periodUtc);

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
