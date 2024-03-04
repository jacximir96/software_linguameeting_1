<?php

namespace App\Src\CoachDomain\InvoiceDomain\Invoice\Service;

use App\Src\TimeDomain\Month\Service\Month;
use Illuminate\Foundation\Http\FormRequest;

class GenerateInvoiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'month' => 'required',
            'year' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'month.required' => trans('common_form.required', ['field' => 'Month']),
            'year.required' => trans('common_form.required', ['field' => 'Year']),
        ];
    }

    public function month(): Month
    {
        return new Month($this->month, $this->year);
    }
}
