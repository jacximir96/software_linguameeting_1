<?php

namespace App\Src\CoachDomain\SalaryDomain\Discount\Action;

use App\Src\CoachDomain\SalaryDomain\Discount\Model\Discount;
use App\Src\CoachDomain\SalaryDomain\Discount\Request\DiscountRequest;
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

    public function handle(DiscountRequest $request, Discount $discount, Currency $currency): Discount
    {

        $discount->type_id = $request->type_id;
        $discount->date = Carbon::parse($request->date);
        $discount->value = $this->linguaMoney->buildFromFloat($request->value, $currency->code);
        $discount->comments = $request->comments ?? '';

        $discount->save();

        return $discount;
    }
}
