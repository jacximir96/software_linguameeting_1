<?php

namespace App\Src\ExperienceDomain\Experience\Action;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\Experience\Request\PublicTipRequest;
use App\Src\Localization\TimeZone\Repository\TimeZoneRepository;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\PaymentDomain\Payment\Action\Command\PayWithCreditCardCommand;
use App\Src\PaymentDomain\Payment\Model\Payment;
use App\Src\PaymentDomain\Payment\Service\BraintreeSale;
use App\Src\PaymentDomain\Payment\Service\CreditCardPaymentDto;
use App\Src\PaymentDomain\Payment\Service\TransactionContext;
use App\Src\PaymentDomain\PaymentDetail\Service\DetailCollection;
use App\Src\ThirdPartiesDomain\Braintree\Service\TransactionResponse;
use App\Src\ThirdPartiesDomain\Braintree\Service\TransactionSaleDto;
use App\Src\UserDomain\User\Model\UserPayable;
use App\Src\UserDomain\UserPublic\Action\Command\CreateUserPublicCommand;
use App\Src\UserDomain\UserPublic\Action\Command\UserDto;
use App\Src\UserDomain\UserPublic\Repository\UserRepository;
use Money\Money;

class CreatePublicTipAction
{
    //construct
    private LinguaMoney $linguaMoney;

    private PayWithCreditCardCommand $payWithCreditCardCommand;

    private UserRepository $userRepository;

    private CreateUserPublicCommand $createUserPublicCommand;

    private BraintreeSale $braintreeSale;

    //status
    private PublicTipRequest $request;

    private Experience $experience;

    private UserPayable $user;

    private Money $amount;

    private TransactionResponse $transactionSaleResponse;

    public function __construct(LinguaMoney $linguaMoney,
        PayWithCreditCardCommand $payWithCreditCardCommand,
        CreateUserPublicCommand $createUserPublicCommand,
        UserRepository $userRepository,
        BraintreeSale $braintreeSale)
    {

        $this->linguaMoney = $linguaMoney;
        $this->payWithCreditCardCommand = $payWithCreditCardCommand;
        $this->userRepository = $userRepository;
        $this->createUserPublicCommand = $createUserPublicCommand;
        $this->braintreeSale = $braintreeSale;
    }

    public function handle(PublicTipRequest $request, Experience $experience)
    {

        $this->initialize($request, $experience);

        $this->configUser();

        $this->processCreditCardPayment();

        $this->savePayment();
    }

    private function initialize(PublicTipRequest $request, Experience $experience)
    {

        $this->request = $request;
        $this->experience = $experience;

        $this->amount = $this->linguaMoney->buildFromFloat($request->amount);
    }

    private function configUser()
    {

        $timezone = TimeZoneRepository::findByName(config('linguameeting.timezone.by_default_in_experiences'));
        $user = $this->userRepository->findByEmail($this->request->email);

        if (is_null($user)) {
            $dto = new UserDto($this->request->name, $this->request->lastname, $this->request->email, '', $timezone);
            $user = $this->createUserPublicCommand->handle($dto);
        } else {
            $user->setTimezone($timezone);
        }

        $this->user = $user;
    }

    private function processCreditCardPayment()
    {

        $infoSale = new TransactionSaleDto($this->user->name, $this->user->lastname, $this->request->amount, $this->request->nonce);

        $context = new TransactionContext('Creating a experience braintree payment with public user', [
            'request' => $this->request,
            'experience' => $this->experience,
            'user' => $this->user,
            'amount' => $this->request->amount,
        ]);

        $this->transactionSaleResponse = $this->braintreeSale->runSale($infoSale, $context);
    }

    private function savePayment(): Payment
    {
        $detailCollection = DetailCollection::fromItem($this->experience);

        $paymentDto = new CreditCardPaymentDto($detailCollection, $this->user, $this->transactionSaleResponse, $this->amount);

        return $this->payWithCreditCardCommand->handle($paymentDto);
    }
}
