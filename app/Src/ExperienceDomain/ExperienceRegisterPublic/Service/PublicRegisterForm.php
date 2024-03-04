<?php

namespace App\Src\ExperienceDomain\ExperienceRegisterPublic\Service;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\ThirdPartiesDomain\Braintree\Service\Braintree;

class PublicRegisterForm extends BaseSearchForm
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

    public function config(Experience $experience)
    {
        $this->action = route('post.public.experience.book.create', $experience->hashId());

        $this->braintreeToken = $this->braintree->createToken();

        $this->model = [];
        $this->model['amount'] = '';
    }
}
