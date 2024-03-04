<?php

namespace App\Src\ExperienceDomain\Experience\Action;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\Experience\Request\TipRequest;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\PaymentDomain\Payment\Action\Command\PayWithCreditCardCommand;
use App\Src\PaymentDomain\Payment\Model\Payment;
use App\Src\PaymentDomain\Payment\Service\BraintreeSale;
use App\Src\PaymentDomain\Payment\Service\CreditCardPaymentDto;
use App\Src\PaymentDomain\Payment\Service\TransactionContext;
use App\Src\PaymentDomain\PaymentDetail\Service\DetailCollection;
use App\Src\ThirdPartiesDomain\Braintree\Service\TransactionResponse;
use App\Src\ThirdPartiesDomain\Braintree\Service\TransactionSaleDto;
use App\Src\UserDomain\User\Model\User;
use Money\Money;

class CreateTipAction
{
    //construct
    private BraintreeSale $braintreeSale;

    private LinguaMoney $linguaMoney;

    private PayWithCreditCardCommand $payWithCreditCardCommand;

    //status
    private TipRequest $request;

    private Experience $experience;

    private User $user;

    private Money $amount;

    private TransactionResponse $transactionSaleResponse;

    public function __construct(BraintreeSale $braintreeSale, LinguaMoney $linguaMoney, PayWithCreditCardCommand $payWithCreditCardCommand)
    {
        $this->braintreeSale = $braintreeSale;
        $this->linguaMoney = $linguaMoney;
        $this->payWithCreditCardCommand = $payWithCreditCardCommand;
    }

    public function handle(TipRequest $request, Experience $experience, User $user)
    {

        $this->initialize($request, $experience, $user);

        $this->processCreditCardPayment();

        $this->savePayment();
    }

    private function initialize(TipRequest $request, Experience $experience, User $user)
    {

        $this->request = $request;
        $this->experience = $experience;
        $this->user = $user;

        $this->amount = $this->linguaMoney->buildFromFloat($request->amount);
    }

    private function processCreditCardPayment()
    {

        $infoSale = new TransactionSaleDto($this->user->name, $this->user->lastname, $this->request->amount, $this->request->nonce);

        $context = new TransactionContext('Creating a experience braintree payment with registered user', [
            'request' => $this->request,
            'experience' => $this->experience,
            'user' => $this->user,
            'amount' => $this->request->amount,
        ]);

        $this->transactionSaleResponse = $this->braintreeSale->runSale($infoSale, $context);
    }

    private function savePayment(): Payment
    {
        $amount = $this->linguaMoney->buildFromFloat($this->request->amount);

        $detailCollection = DetailCollection::fromItem($this->experience);

        $paymentDto = new CreditCardPaymentDto($detailCollection, $this->user, $this->transactionSaleResponse, $amount);

        return $this->payWithCreditCardCommand->handle($paymentDto);
    }
}
