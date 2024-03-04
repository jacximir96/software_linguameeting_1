<?php

namespace App\Src\StudentDomain\Makeup\Request;

use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use App\Src\StudentDomain\Makeup\Service\MakeupSearcher;
use Illuminate\Foundation\Http\FormRequest;

class BuyMakeupRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $numberMakeupsRules = app(NumberMakeupsRule::class, [
            'request' => $this,
            'enrollment' => $this->enrollment,
            'makeupSearcher' => app(MakeupSearcher::class)
            ]);

        return [
            'number_makeups' => ['required', 'numeric', $numberMakeupsRules]
        ];
    }

    public function messages()
    {
        return [
            'number_makeups.required' => trans('common_form.required', ['field' => 'number of Make-ups']),
        ];
    }
}
