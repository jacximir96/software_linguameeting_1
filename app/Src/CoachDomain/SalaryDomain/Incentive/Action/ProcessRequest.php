<?php

namespace App\Src\CoachDomain\SalaryDomain\Incentive\Action;

use App\Src\CoachDomain\SalaryDomain\Incentive\Model\Incentive;
use App\Src\CoachDomain\SalaryDomain\Incentive\Request\IncentiveRequest;
use App\Src\PaymentDomain\Currency\Model\Currency;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use Carbon\Carbon;

class ProcessRequest
{
    private LinguaMoney $linguaMoney;

    public function __construct(LinguaMoney $linguaMoney)
    {
        $this->linguaMoney = $linguaMoney;
    }

    public function handle(IncentiveRequest $request, Incentive $incentive, Currency $currency): Incentive
    {

        $incentive->type_id = $request->type_id;
        $incentive->frequency_id = $request->frequency_id;
        $incentive->date = Carbon::parse($request->date);
        $incentive->value = $this->linguaMoney->buildFromFloat($request->value, $currency->code);
        $incentive->comments = $request->comments ?? '';

        $incentive->save();

        return $incentive;
    }
}
