<?php

namespace App\Src\ExperienceDomain\ExperienceRegisterPublic\Action;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegister\Exception\UserAlreadyRegisteredInExperience;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Action\Command\CreateExperienceRegisterCommand;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Model\ExperienceRegisterPublic;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Repository\ExperienceRegisterPublicRepository;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Request\PublicRegisterRequest;
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

class RegisterUserWithCreditCardAction
{
    //construct
    private ExperienceRegisterPublicRepository $experienceRegisterPublicRepository;

    private BraintreeSale $braintreeSale;

    private LinguaMoney $linguaMoney;

    private PayWithCreditCardCommand $payWithCreditCardCommand;

    private CreateExperienceRegisterCommand $createExperienceRegisterCommand;

    //status
    private PublicRegisterRequest $request;

    private Experience $experience;

    private ExperienceRegisterPublic $experienceRegisterPublic;

    private UserPayable $user;

    private TransactionResponse $transactionSaleResponse;

    public function __construct(ExperienceRegisterPublicRepository $experienceRegisterPublicRepository,
        BraintreeSale $braintreeSale,
        LinguaMoney $linguaMoney,
        PayWithCreditCardCommand $payWithCreditCardCommand,
        CreateExperienceRegisterCommand $createExperienceRegisterCommand)
    {
        $this->experienceRegisterPublicRepository = $experienceRegisterPublicRepository;
        $this->braintreeSale = $braintreeSale;
        $this->linguaMoney = $linguaMoney;
        $this->payWithCreditCardCommand = $payWithCreditCardCommand;
        $this->createExperienceRegisterCommand = $createExperienceRegisterCommand;
    }

    public function handle(PublicRegisterRequest $request, Experience $experience, UserPayable $user): ExperienceRegisterPublic
    {

        $this->initialize($request, $experience, $user);

        $this->checkUserIsNotRegisteredInExperience();

        $this->createRegister();

        $this->processCreditCardPayment();

        $this->saveCreditCardPayment();

        return $this->experienceRegisterPublic;
    }

    private function initialize(PublicRegisterRequest $request, Experience $experience, UserPayable $user)
    {

        $this->request = $request;
        $this->experience = $experience;
        $this->user = $user;
    }

    private function checkUserIsNotRegisteredInExperience()
    {

        if ($this->experienceRegisterPublicRepository->checkUserInExperience($this->experience, $this->user)) {
            throw new UserAlreadyRegisteredInExperience();
        }
    }

    private function createRegister()
    {
        $this->experienceRegisterPublic = $this->createExperienceRegisterCommand->handle($this->experience, $this->user);
    }

    private function processCreditCardPayment()
    {

        $amount = $this->linguaMoney->formatToFloat($this->experience->price);
        $infoSale = new TransactionSaleDto($this->user->name, $this->user->lastname, $amount, $this->request->nonce);

        $context = new TransactionContext('When create a register in a public experience with public user.', [
            'request' => $this->request,
            'experience' => $this->experience,
            'user' => $this->user,
        ]);

        $this->transactionSaleResponse = $this->braintreeSale->runSale($infoSale, $context);
    }

    private function saveCreditCardPayment(): Payment
    {
        $detailCollection = DetailCollection::fromItem($this->experienceRegisterPublic);

        $paymentDto = new CreditCardPaymentDto($detailCollection, $this->user, $this->transactionSaleResponse, $this->experience->price);

        return $this->payWithCreditCardCommand->handle($paymentDto);
    }
}
