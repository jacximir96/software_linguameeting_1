<?php

namespace App\Src\StudentDomain\Student\Service;

use App\Src\CourseDomain\Section\Model\Section;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\ThirdPartiesDomain\Braintree\Service\Braintree;

class PersonalDataRegisterForm extends BaseSearchForm
{
    private $braintreeToken = '';

    private Braintree $braintree;

    private LinguaMoney $linguaMoney;

    public function braintreeToken(): string
    {
        return $this->braintreeToken;
    }

    public function __construct(Braintree $braintree, LinguaMoney $linguaMoney)
    {

        $this->braintree = $braintree;
        $this->linguaMoney = $linguaMoney;
    }

    public function config(Section $section)
    {
        $this->action = route('post.public.register.student.personal_data', $section->code);

        $this->braintreeToken = $this->braintree->createToken();

        $this->model = [];
        $this->model['amount'] = $this->linguaMoney->formatToFloat($section->course->price());
    }
}
