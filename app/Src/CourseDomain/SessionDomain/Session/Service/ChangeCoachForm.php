<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Service;

use App\Src\CoachDomain\CoachSchedule\Repository\CoachScheduleRepository;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\StudentRole\BookSession\Service\Availability\Availability;
use App\Src\StudentRole\BookSession\Service\Availability\AvailabilityBuilder;
use App\Src\StudentRole\BookSession\Service\Availability\AvailabilityLoader;
use App\Src\StudentRole\BookSession\Service\Availability\Filter;
use App\Src\StudentRole\BookSession\Service\Availability\FilterBuilder;

class ChangeCoachForm extends BaseSearchForm
{
    //construct
    private CoachScheduleRepository $coachScheduleRepository;

    private AvailabilityBuilder $availabilityBuilder;

    private AvailabilityLoader $availabilityLoader;

    private FilterBuilder $filterBuilder;

    //status
    private Session $session;

    private array $coachesOptions;

    public function __construct(CoachScheduleRepository $coachScheduleRepository,
        AvailabilityBuilder $availabilityBuilder,
        AvailabilityLoader $availabilityLoader,
        FilterBuilder $filterBuilder)
    {
        $this->coachScheduleRepository = $coachScheduleRepository;
        $this->availabilityBuilder = $availabilityBuilder;
        $this->availabilityLoader = $availabilityLoader;
        $this->filterBuilder = $filterBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function config(Session $session)
    {
        $this->initialize($session);

        $this->configCoachOptions();
    }

    private function initialize(Session $session)
    {

        $this->session = $session;

        $this->action = route('post.admin.coach.calendar.availability.session.change_coach', $session->id);

        $this->model = [];
    }

    private function configCoachOptions()
    {

        $availability = $this->initializeAvailability();

        $filter = $this->obtainAvailabilityFilter();

        $this->availabilityLoader->loadAvailabilityForBookSession($availability, $filter);

        $coaches = collect();
        foreach ($availability->hours() as $availabilitiesTimeHour) {

            foreach ($availabilitiesTimeHour->coachFreeSlots() as $coachFreeSlot) {
                $coach = $coachFreeSlot->coach();

                if (! $coaches->has($coach->id)) {
                    $coaches->put($coach->id, $coach->writeFullName());
                }
            }
        }

        $this->coachesOptions = $coaches->toArray();
    }

    private function initializeAvailability(): Availability
    {
        return $this->availabilityBuilder->buildForSession($this->session);
    }

    private function obtainAvailabilityFilter(): Filter
    {
        return $this->filterBuilder->buildForSession($this->session);
    }
}
