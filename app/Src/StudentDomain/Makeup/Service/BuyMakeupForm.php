<?php
namespace App\Src\StudentDomain\Makeup\Service;

use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\ThirdPartiesDomain\Braintree\Service\Braintree;

class BuyMakeupForm extends BaseSearchForm
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

    public function config(Enrollment $enrollment)
    {
        $this->action = route('post.student.session.book.makeup.buy', $enrollment->hashId());

        $this->braintreeToken = $this->braintree->createToken();

        $this->model = [];
        $this->model['amount'] = '';
        $this->model['number_makeups'] = 1;
    }
}
