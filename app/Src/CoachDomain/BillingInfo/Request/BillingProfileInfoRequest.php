<?php

namespace App\Src\CoachDomain\BillingInfo\Request;

use App\Src\CoachDomain\BillingInfo\Rule\SwiftRule;
use App\Src\Localization\Country\Model\Country;
use App\Src\PaymentDomain\MethodPayment\Model\MethodPayment;
use Illuminate\Foundation\Http\FormRequest;

class BillingProfileInfoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $swiftRule = new SwiftRule($this);

        return [
            'full_name' => 'required',
            'ind' => 'required',
            'address' => 'required',
            'postal_code' => 'required',
            'city' => 'required',
            'country_id' => 'required',

            'bank_name' => 'required',
            'bank_account' => 'required',
            'swift' => [$swiftRule],
            'route_number' => 'required_if:country_id,'.Country::USA_ID,
            'account_type_id' => 'required_if:country_id,'.Country::USA_ID,

            'method_payment_id' => 'required',
            'currency_id' => 'required',
            'paypal_email' => 'required_if:method_payment_id,'.MethodPayment::ID_PAYPAL,
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => trans('common_form.required', ['field' => 'Full Name']),
            'ind.required' => trans('common_form.required', ['field' => 'Identity National Document']),
            'address.required' => trans('common_form.required', ['field' => 'Address']),
            'postal_code.required' => trans('common_form.required', ['field' => 'Postal Code']),
            'city.required' => trans('common_form.required', ['field' => 'City']),
            'country_id.required' => trans('common_form.required', ['field' => 'Country']),

            'bank_name.required' => trans('common_form.required', ['field' => 'Bank Name']),
            'bank_account.required' => trans('common_form.required', ['field' => 'Bank Account']),
            'swift.required' => trans('common_form.required', ['field' => 'Swift']),
            'route_number.required_if' => trans('common_form.required_if', ['field_one' => 'Route Number', 'field_two' => 'Country', 'value' => 'USA']),
            'account_type_id.required_if' => trans('common_form.required_if', ['field_one' => 'Route Number', 'field_two' => 'Country', 'value' => 'USA']),

            'method_payment_id.required' => trans('common_form.required', ['field' => 'Method Payment']),
            'currency_id.required' => trans('common_form.required', ['field' => 'Currency']),
            'paypal_email.required_if' => trans('common_form.required_if', ['field_one' => 'Paypal Email', 'field_two' => 'Method Payment', 'value' => 'Paypal']),
        ];
    }
}
