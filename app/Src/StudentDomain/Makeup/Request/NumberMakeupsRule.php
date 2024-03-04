<?php

namespace App\Src\StudentDomain\Makeup\Request;

use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Makeup\Service\MakeupAvailability;
use App\Src\StudentDomain\Makeup\Service\MakeupSearcher;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class NumberMakeupsRule implements Rule
{
    private BuyMakeupRequest $request;

    private Enrollment $enrollment;

    private MakeupSearcher $makeupSearcher;

    private MakeupAvailability $makeupAvailability;

    public function __construct(BuyMakeupRequest $request, Enrollment $enrollment, MakeupSearcher $makeupSearcher)
    {
        $this->request = $request;
        $this->enrollment = $enrollment;
        $this->makeupSearcher = $makeupSearcher;

        $this->makeupAvailability = $makeupSearcher->searchFromEnrollment($this->enrollment);
    }

    public function passes($attribute, $value)
    {

        if ($value > $this->makeupAvailability->numMaxAvailableForPurchase()->get()){
            return false;
        }

        return true;
    }

    public function message()
    {
        return trans('payment.makeup.error.number_makeups_excedeed', ['number' => $this->makeupAvailability->numMaxAvailableForPurchase()->get()]);
    }
}
