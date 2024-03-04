<?php

namespace App\Src\CoachDomain\BillingInfo\Rule;

use App\Src\CoachDomain\BillingInfo\Request\BillingProfileInfoRequest;
use App\Src\Localization\Country\Model\Country;
use Illuminate\Contracts\Validation\Rule;

class SwiftRule implements Rule
{
    private BillingProfileInfoRequest $request;

    public function __construct(BillingProfileInfoRequest $request)
    {
        $this->request = $request;

    }

    public function passes($attribute, $value)
    {
        if ($this->request->country_id == Country::USA_ID) {
            return true;
        }

        if (is_null($value) or empty($value)) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'Swift is required when Country not is USA.';
    }
}
