<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Action;

use App\Src\CoachDomain\CoachSchedule\Action\Command\CleanSessionCommand;
use App\Src\CourseDomain\SessionDomain\ReplacedCoach\Action\Command\ReplaceCoachCommand;
use App\Src\CourseDomain\SessionDomain\Session\Action\Command\UpdateSessionFromCoachScheduleCommand;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Request\ChangeSessionCoachRequest;
use App\Src\CourseDomain\SessionDomain\Session\Service\ScheduleSession;
use App\Src\StudentRole\BookSession\Service\Availability\Availability;
use App\Src\StudentRole\BookSession\Service\Availability\AvailabilityBuilder;
use App\Src\StudentRole\BookSession\Service\Availability\AvailabilityLoader;
use App\Src\StudentRole\BookSession\Service\Availability\Filter;
use App\Src\StudentRole\BookSession\Service\Availability\FilterBuilder;
use App\Src\StudentRole\BookSession\Service\Availability\TimeSlot;
use App\Src\UserDomain\User\Model\User;

class ChangeSessionCoachAction
{
    //construct
    private AvailabilityBuilder $availabilityBuilder;

    private AvailabilityLoader $availabilityLoader;

    private FilterBuilder $filterBuilder;

    private ReplaceCoachCommand $replaceCoachCommand;

    private CleanSessionCommand $cleanSessionCommand;

    private UpdateSessionFromCoachScheduleCommand $updateSessionFromCoachScheduleCommand;

    //status
    private Session $session;

    private ChangeSessionCoachRequest $request;

    private User $coach;

    public function __construct(AvailabilityBuilder $availabilityBuilder,
        AvailabilityLoader $availabilityLoader,
        FilterBuilder $filterBuilder,
        ReplaceCoachCommand $replaceCoachCommand,
        CleanSessionCommand $cleanSessionCommand,
        UpdateSessionFromCoachScheduleCommand $updateSessionFromCoachScheduleCommand)
    {
        $this->availabilityBuilder = $availabilityBuilder;
        $this->availabilityLoader = $availabilityLoader;
        $this->filterBuilder = $filterBuilder;
        $this->replaceCoachCommand = $replaceCoachCommand;
        $this->cleanSessionCommand = $cleanSessionCommand;
        $this->updateSessionFromCoachScheduleCommand = $updateSessionFromCoachScheduleCommand;
    }

    public function handle(ChangeSessionCoachRequest $request, Session $session)
    {

        $this->initialize($request, $session);

        $this->saveReplacedCoach();

        $this->detachCurrentCoachScheduleFromSession();

        $this->attachNewCoachScheduleToSession();

    }

    private function initialize(ChangeSessionCoachRequest $request, Session $session)
    {
        $this->request = $request;
        $this->session = $session;
        $this->coach = User::find($this->request->coach_id);
    }

    private function saveReplacedCoach()
    {
        $this->replaceCoachCommand->handle($this->session, $this->coach);
    }

    private function detachCurrentCoachScheduleFromSession()
    {

        foreach ($this->session->coachSchedule as $coachSchedule) {
            $this->cleanSessionCommand->handle($coachSchedule);
        }
    }

    private function attachNewCoachScheduleToSession()
    {

        $availability = $this->initializeAvailability();

        $filter = $this->obtainAvailabilityFilter();

        $this->availabilityLoader->loadAvailabilityForBookSession($availability, $filter);

        $startTime = null;
        foreach ($availability->hours() as $availabilitiesTimeHour) {

            foreach ($availabilitiesTimeHour->coachFreeSlots() as $coachFreeSlot) {

                foreach ($coachFreeSlot->freeSlots() as $freeSlot) {

                    foreach ($freeSlot->coachSchedules() as $coachSchedule) {

                        $coachSchedule->session_id = $this->session->id;
                        $coachSchedule->save();

                        if (is_null($startTime)) {
                            $startTime = $coachSchedule->start_time;
                        }
                    }
                }
            }
        }

        $timeSlot = TimeSlot::buildFromTimeString($startTime, $coachSchedule->end_time);

        $scheduleSession = new ScheduleSession($coachSchedule->day, $timeSlot, $coachSchedule->timeZone);

        $this->updateSessionFromCoachScheduleCommand->handle($this->session, $this->coach, $scheduleSession);
    }

    private function initializeAvailability(): Availability
    {
        return $this->availabilityBuilder->buildForSession($this->session);
    }

    private function obtainAvailabilityFilter(): Filter
    {
        $coachesIds = [$this->request->coach_id];

        return $this->filterBuilder->buildForSessionWithCustomCoaches($this->session, $coachesIds);

    }
}
