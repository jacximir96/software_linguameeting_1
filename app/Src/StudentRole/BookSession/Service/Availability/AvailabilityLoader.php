<?php

namespace App\Src\StudentRole\BookSession\Service\Availability;

use App\Src\CoachDomain\CoachSchedule\Repository\CoachScheduleRepository;
use App\Src\StudentRole\BookSession\Service\Availability\Algorithm\Algorithm;
use App\Src\StudentRole\BookSession\Service\Availability\Algorithm\Filter as AlgorithmFilter;

class AvailabilityLoader
{
    private CoachScheduleRepository $coachScheduleRepository;

    private Algorithm $sortAlgorithm;

    public function __construct(CoachScheduleRepository $coachScheduleRepository, Algorithm $sortAlgorithm)
    {
        $this->coachScheduleRepository = $coachScheduleRepository;
        $this->sortAlgorithm = $sortAlgorithm;
    }

    public function loadAvailabilityForBookSession(Availability $availability, Filter $filter): Availability
    {
        $coachSchedules = $this->coachScheduleRepository->obtainAvailabilityforBookSession($filter);

        //filtrar la disponibilidad para quedarnos de cada coach aquella disponiiblidad que tiene el hueco suficiente como para tener el tiempo de sesión.
        //aquí de momento trabajamos con todos los datos obtenidos de cada coach de manera natural, únicamente filtramos los huecos que nos sirven.
        $coachesAvailabilities = collect();
        foreach ($coachSchedules as $coachSchedule) {

            $coachId = $coachSchedule->coach_id;

            if (! $coachesAvailabilities->has($coachId)) {
                $coachAvailability = new CoachAvailability($coachSchedule->coach, $filter);
                $coachesAvailabilities->put($coachId, $coachAvailability);
            }

            $coachAvailability = $coachesAvailabilities->get($coachId);

            $coachAvailability->addCoachSchedule($coachSchedule);
        }

        //encajar cada disponibilidad en el rango de horas seleccionados (afternoon, morning..etc)
        foreach ($coachesAvailabilities as $coachAvailability) {
            foreach ($coachAvailability->freeSlots() as $freeSlot) {
                $availability->addFreeSlot($freeSlot, $filter->timeZone());
            }
        }

        $algorithmFilter = new AlgorithmFilter($filter->course(), $filter->dateSlot());
        //hours() -> cada tramo horario con un array cada uno de CoachFreeSlots (coach + freeSlots)
        foreach ($availability->hours() as $availabilitiesTimeHour){

            $coachesScored = $this->sortAlgorithm->sort($availabilitiesTimeHour->coachFreeSlots(), $algorithmFilter);

            $availabilitiesTimeHour->assignCoachesScored($coachesScored);
        }
        return $availability;
    }
}
