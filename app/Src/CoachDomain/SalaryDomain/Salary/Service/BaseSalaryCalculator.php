<?php

namespace App\Src\CoachDomain\SalaryDomain\Salary\Service;

use App\Src\CoachDomain\SalaryDomain\Salary\Model\Salary;
use App\Src\CoachDomain\SalaryDomain\Salary\Repository\SalaryRepository;
use App\Src\CoachDomain\SalaryDomain\SalaryType\Model\SalaryType;
use App\Src\CourseDomain\SessionDomain\Session\Repository\SessionRepository;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\TimeDomain\Month\Service\Month;
use App\Src\UserDomain\User\Model\User;

class BaseSalaryCalculator
{
    //construct
    private SalaryRepository $salaryRepository;

    private SessionRepository $sessionRepository;

    private LinguaMoney $linguaMoney;

    public function __construct(SalaryRepository $salaryRepository, SessionRepository $sessionRepository, LinguaMoney $linguaMoney)
    {

        $this->salaryRepository = $salaryRepository;
        $this->sessionRepository = $sessionRepository;
        $this->linguaMoney = $linguaMoney;
    }

    public function obtainBaseSalary(Month $month, User $coach): BaseSalary
    {

        $salary = $this->salaryRepository->obtainForCoach($coach);

        if (is_null($salary)) {
            return $this->baseSalaryInitialized($month, $coach);
        }

        if ($salary->type->isFixed()) {
            return new BaseSalary($month, $salary->value, 0, $salary->type);
        }

        return $this->calculateSalaryByHours($salary, $month, $coach);
    }

    private function baseSalaryInitialized(Month $month, User $coach): BaseSalary
    {

        $salaryType = SalaryType::find(SalaryType::PER_HOUR_ID);

        return new BaseSalary($month, $this->linguaMoney->buildZero($coach->currency()->code), 0, $salaryType);

    }

    private function calculateSalaryByHours(Salary $salary, Month $month, User $coach): BaseSalary
    {

        $sessions = $this->sessionRepository->obtainSessionForSalary($coach, $month->period());

        $seconds = 0;
        foreach ($sessions as $session) {
            $seconds += $session->differenceInSeconds('start_time', 'end_time');
        }

        $hours = round($seconds / 3600, 2);
        $salaryValueInCents = $salary->value->getAmount() * $hours;
        $salaryValueInMoney = $salaryValueInCents / 100;

        $salaryValue = $this->linguaMoney->buildFromFloat($salaryValueInMoney);

        return new BaseSalary($month, $salaryValue, $hours, $salary->type);
    }
}
