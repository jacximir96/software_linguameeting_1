<?php

namespace App\Src\ExperienceDomain\ExperienceRegister\Action;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegister\Action\Command\CreateExperienceRegisterCommand;
use App\Src\ExperienceDomain\ExperienceRegister\Exception\UserAlreadyRegisteredInExperience;
use App\Src\ExperienceDomain\ExperienceRegister\Model\ExperienceRegister;
use App\Src\ExperienceDomain\ExperienceRegister\Repository\ExperienceRegisterRepository;
use App\Src\ExperienceDomain\ExperienceRegister\Request\UserRegisterRequest;
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

class RegisterUserWithCreditCardAction
{
    //construct
    private ExperienceRegisterRepository $experienceRegisterRepository;

    private BraintreeSale $braintreeSale;

    private LinguaMoney $linguaMoney;

    private PayWithCreditCardCommand $payWithCreditCardCommand;

    private CreateExperienceRegisterCommand $createExperienceRegisterCommand;

    //status
    private UserRegisterRequest $request;

    private Experience $experience;

    private ExperienceRegister $experienceRegister;

    private User $user;

    private Money $amount;

    private TransactionResponse $transactionSaleResponse;

    public function __construct(ExperienceRegisterRepository $experienceRegisterRepository,
        BraintreeSale $braintreeSale,
        LinguaMoney $linguaMoney,
        PayWithCreditCardCommand $payWithCreditCardCommand,
        CreateExperienceRegisterCommand $createExperienceRegisterCommand)
    {
        $this->experienceRegisterRepository = $experienceRegisterRepository;
        $this->braintreeSale = $braintreeSale;
        $this->linguaMoney = $linguaMoney;
        $this->payWithCreditCardCommand = $payWithCreditCardCommand;
        $this->createExperienceRegisterCommand = $createExperienceRegisterCommand;
    }

    public function handle(UserRegisterRequest $request, Experience $experience, User $user): ExperienceRegister
    {

        $this->initialize($request, $experience, $user);

        $this->checkUserIsNotRegisteredInExperience();

        $this->createRegister();

        $this->processCreditCardPayment();

        $this->saveCreditCardPayment();

        return $this->experienceRegister;
    }

    private function initialize(UserRegisterRequest $request, Experience $experience, User $user)
    {

        $this->request = $request;
        $this->experience = $experience;
        $this->user = $user;

        $this->amount = $this->linguaMoney->buildFromFloat($request->amount);
    }

    private function checkUserIsNotRegisteredInExperience()
    {

        if ($this->experienceRegisterRepository->checkUserInExperience($this->experience, $this->user)) {
            throw new UserAlreadyRegisteredInExperience();
        }
    }

    private function createRegister()
    {
        $this->experienceRegister = $this->createExperienceRegisterCommand->handle($this->experience, $this->user);
    }

    private function processCreditCardPayment()
    {

        $amount = $this->linguaMoney->formatToFloat($this->experience->price);

        $infoSale = new TransactionSaleDto($this->user->name, $this->user->lastname, $amount, $this->request->nonce);

        $context = new TransactionContext('When create a register in an experience with a registered user.', [
            'experienceRegister' => $this->experienceRegister,
            'request' => $this->request,
        ]);

        $this->transactionSaleResponse = $this->braintreeSale->runSale($infoSale, $context);
    }

    private function saveCreditCardPayment(): Payment
    {
        $amount = $this->linguaMoney->buildFromFloat($this->request->amount);

        $detailCollection = DetailCollection::fromItem($this->experienceRegister);

        $paymentDto = new CreditCardPaymentDto($detailCollection, $this->user, $this->transactionSaleResponse, $amount);

        return $this->payWithCreditCardCommand->handle($paymentDto);
    }
}
