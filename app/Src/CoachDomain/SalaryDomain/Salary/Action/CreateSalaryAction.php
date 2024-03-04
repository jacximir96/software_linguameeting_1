<?php

namespace App\Src\CoachDomain\SalaryDomain\Salary\Action;

use App\Src\CoachDomain\SalaryDomain\Salary\Model\Salary;
use App\Src\CoachDomain\SalaryDomain\Salary\Request\SalaryRequest;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\UserDomain\User\Model\User;

class CreateSalaryAction
{
    private LinguaMoney $linguaMoney;

    public function __construct(LinguaMoney $linguaMoney)
    {

        $this->linguaMoney = $linguaMoney;
    }

    public function handle(SalaryRequest $request, User $coach): Salary
    {

        $salary = $this->createSalary($request, $coach);

        $this->updateIsPayer($request, $coach);

        return $salary;
    }

    private function createSalary (SalaryRequest $request, User $coach):Salary{

        $currency = $coach->billingInfo->currency;

        $salary = new Salary();
        $salary->coach_id = $coach->id;
        $salary->salary_type_id = $request->salary_type_id;
        $salary->value = $this->linguaMoney->buildFromFloat($request->value, $currency->code);
        $salary->comments = $request->comments ?? '';

        $salary->extra_coordinator = null;
        if ($request->filled('extra_coordinator')) {
            $salary->extra_coordinator = $this->linguaMoney->buildFromFloat($request->extra_coordinator);
        }

        $salary->save();

        return $salary;

    }

    private function updateIsPayer(SalaryRequest $request, User $coach)
    {

        $coachInfo = $coach->coachInfo;

        if ($coachInfo) {
            $coachInfo->is_payer = $request->has('is_payer') ? true : false;
            $coachInfo->save();
        }
    }
}
