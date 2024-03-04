<?php

namespace App\Src\ExperienceDomain\ExperienceRegister\Action;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegister\Action\Command\CreateExperienceRegisterCommand;
use App\Src\ExperienceDomain\ExperienceRegister\Exception\UserAlreadyRegisteredInExperience;
use App\Src\ExperienceDomain\ExperienceRegister\Model\ExperienceRegister;
use App\Src\ExperienceDomain\ExperienceRegister\Repository\ExperienceRegisterRepository;
use App\Src\ExperienceDomain\ExperienceRegister\Request\UserRegisterRequest;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\PaymentDomain\Payment\Action\Command\PayWithCodeCommand;
use App\Src\PaymentDomain\Payment\Model\Payment;
use App\Src\PaymentDomain\Payment\Service\CodePaymentDto;
use App\Src\PaymentDomain\PaymentDetail\Service\DetailCollection;
use App\Src\RegisterCodeDomain\RegisterCode\Model\KeyCode;
use App\Src\RegisterCodeDomain\RegisterCode\Model\RegisterCode;
use App\Src\RegisterCodeDomain\RegisterCode\Repository\CodeRepository;
use App\Src\RegisterCodeDomain\RegisterCode\Service\RegisterCodeChecker;
use App\Src\UserDomain\User\Model\User;
use Money\Money;

class RegisterUserWithCodeAction
{
    //construct
    private RegisterCodeChecker $registerCodeChecker;

    private CodeRepository $codeRepository;

    private ExperienceRegisterRepository $experienceRegisterRepository;

    private LinguaMoney $linguaMoney;

    private PayWithCodeCommand $payWithCodeCommand;

    private CreateExperienceRegisterCommand $createExperienceRegisterCommand;

    //status
    private UserRegisterRequest $request;

    private Experience $experience;

    private ExperienceRegister $experienceRegister;

    private User $user;

    private Money $amount;

    private RegisterCode $registerCode;

    public function __construct(RegisterCodeChecker $registerCodeChecker,
        CodeRepository $codeRepository,
        ExperienceRegisterRepository $experienceRegisterRepository,
        LinguaMoney $linguaMoney,
        PayWithCodeCommand $payWithCodeCommand,
        CreateExperienceRegisterCommand $createExperienceRegisterCommand)
    {

        $this->registerCodeChecker = $registerCodeChecker;
        $this->codeRepository = $codeRepository;
        $this->linguaMoney = $linguaMoney;
        $this->payWithCodeCommand = $payWithCodeCommand;
        $this->createExperienceRegisterCommand = $createExperienceRegisterCommand;
        $this->experienceRegisterRepository = $experienceRegisterRepository;
    }

    public function handle(UserRegisterRequest $request, Experience $experience, User $user): ExperienceRegister
    {

        $this->initialize($request, $experience, $user);

        $this->checkUserIsNotRegisteredInExperience();

        $this->checkRegisterCodeIsValid();

        $this->createRegisterInExperience();

        $this->processCodePayment();

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

    private function checkRegisterCodeIsValid()
    {

        $keyCode = new KeyCode($this->request->code);

        $this->registerCodeChecker->checkCodeIsValidForRegistration($keyCode);

        $this->registerCode = $this->codeRepository->findByCode($keyCode);
    }

    private function createRegisterInExperience()
    {

        $this->experienceRegister = $this->createExperienceRegisterCommand->handle($this->experience, $this->user);
    }

    private function processCodePayment():Payment
    {
        $detailCollection = DetailCollection::fromItem($this->experienceRegister);

        $paymentDto = new CodePaymentDto($detailCollection, $this->user, $this->registerCode, $this->experience->price);

        return $this->payWithCodeCommand->handle($paymentDto);
    }
}
