<?php

namespace App\Src\CoachDomain\SalaryDomain\Salary\Service;

use App\Src\CoachDomain\CoachCoordinator\Repository\CoachCoordinatorRepository;
use App\Src\CoachDomain\SalaryDomain\Salary\Repository\SalaryRepository;
use App\Src\CourseDomain\SessionDomain\Session\Repository\SessionRepository;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\TimeDomain\Month\Service\Month;
use App\Src\UserDomain\User\Model\User;

class ExtraSalaryCalculator
{
    //construct
    private SalaryRepository $salaryRepository;

    private SessionRepository $sessionRepository;

    private CoachCoordinatorRepository $coachCoordinatorRepository;

    private LinguaMoney $linguaMoney;

    public function __construct(SalaryRepository $salaryRepository,
        SessionRepository $sessionRepository,
        CoachCoordinatorRepository $coachCoordinatorRepository,
        LinguaMoney $linguaMoney)
    {

        $this->salaryRepository = $salaryRepository;
        $this->sessionRepository = $sessionRepository;
        $this->coachCoordinatorRepository = $coachCoordinatorRepository;
        $this->linguaMoney = $linguaMoney;
    }

    public function obtainExtraSalary(Month $month, User $coach): ExtraSalary
    {

        $salary = $this->salaryRepository->obtainForCoach($coach);

        if (! $salary) {
            return new ExtraSalary($month, $this->linguaMoney->buildZero($coach->currency()->code), 0);
        }

        if (! $salary->hasExtraCoordinator()) {
            return new ExtraSalary($month, $this->linguaMoney->buildZero($coach->currency()->code), 0);
        }

        $coachCoordinateds = $this->coachCoordinatorRepository->obtainCoordinatedFromCoordinator($coach);

        $totalHours = 0;
        foreach ($coachCoordinateds as $coachCoordinatedRow) {

            $coachHours = $this->obtainSessionHoursFromCoachCoordinated($month, $coachCoordinatedRow->coach);

            $totalHours += $coachHours;
        }

        $totalHours = $totalHours * $this->linguaMoney->formatToFloat($salary->extra_coordinator);

        $extraSalary = $this->linguaMoney->buildFromFloat($totalHours);

        return new ExtraSalary($month, $extraSalary, $totalHours);
    }

    private function obtainSessionHoursFromCoachCoordinated(Month $month, User $coachCoordinated): float
    {

        $coachHours = 0;
        $sessions = $this->sessionRepository->obtainSessionForSalary($coachCoordinated, $month->period());

        foreach ($sessions as $session) {
            $coachHours += $session->durationInHours('start_time', 'end_time');
        }

        return $coachHours;
    }
}
