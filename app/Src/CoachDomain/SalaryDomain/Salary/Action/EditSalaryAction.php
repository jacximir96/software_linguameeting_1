<?php

namespace App\Src\CoachDomain\SalaryDomain\Salary\Action;

use App\Src\CoachDomain\SalaryDomain\Salary\Model\Salary;
use App\Src\CoachDomain\SalaryDomain\Salary\Request\SalaryRequest;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;

class EditSalaryAction
{
    private LinguaMoney $linguaMoney;

    public function __construct(LinguaMoney $linguaMoney)
    {

        $this->linguaMoney = $linguaMoney;
    }

    public function handle(SalaryRequest $request, Salary $salary): Salary
    {

        $this->updateIsPayer($request, $salary);

        $currency = $salary->coach->billingInfo->currency;

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

    private function updateIsPayer(SalaryRequest $request, Salary $salary)
    {

        $coach = $salary->coach;
        $coachInfo = $coach->coachInfo;

        if ($coachInfo) {
            $coachInfo->is_payer = $request->has('is_payer') ? true : false;
            $coachInfo->save();
        }

    }
}
