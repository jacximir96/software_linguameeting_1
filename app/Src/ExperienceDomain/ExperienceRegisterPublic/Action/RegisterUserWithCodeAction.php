<?php

namespace App\Src\ExperienceDomain\ExperienceRegisterPublic\Action;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegister\Exception\UserAlreadyRegisteredInExperience;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Action\Command\CreateExperienceRegisterCommand;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Model\ExperienceRegisterPublic;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Repository\ExperienceRegisterPublicRepository;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Request\PublicRegisterRequest;
use App\Src\PaymentDomain\Payment\Action\Command\PayWithCodeCommand;
use App\Src\PaymentDomain\Payment\Service\CodePaymentDto;
use App\Src\PaymentDomain\PaymentDetail\Service\DetailCollection;
use App\Src\RegisterCodeDomain\RegisterCode\Model\KeyCode;
use App\Src\RegisterCodeDomain\RegisterCode\Model\RegisterCode;
use App\Src\RegisterCodeDomain\RegisterCode\Repository\CodeRepository;
use App\Src\RegisterCodeDomain\RegisterCode\Service\RegisterCodeChecker;
use App\Src\UserDomain\User\Model\UserPayable;

class RegisterUserWithCodeAction
{
    //construct
    private RegisterCodeChecker $registerCodeChecker;

    private CodeRepository $codeRepository;

    private ExperienceRegisterPublicRepository $experienceRegisterPublicRepository;

    private PayWithCodeCommand $payWithCodeCommand;

    private CreateExperienceRegisterCommand $createExperienceRegisterCommand;

    //status
    private PublicRegisterRequest $request;

    private Experience $experience;

    private ExperienceRegisterPublic $experienceRegisterPublic;

    private UserPayable $user;

    private RegisterCode $registerCode;

    public function __construct(RegisterCodeChecker $registerCodeChecker,
        CodeRepository $codeRepository,
        ExperienceRegisterPublicRepository $experienceRegisterPublicRepository,
        PayWithCodeCommand $payWithCodeCommand,
        CreateExperienceRegisterCommand $createExperienceRegisterCommand)
    {

        $this->registerCodeChecker = $registerCodeChecker;
        $this->codeRepository = $codeRepository;
        $this->payWithCodeCommand = $payWithCodeCommand;
        $this->createExperienceRegisterCommand = $createExperienceRegisterCommand;
        $this->experienceRegisterPublicRepository = $experienceRegisterPublicRepository;
    }

    public function handle(PublicRegisterRequest $request, Experience $experience, UserPayable $user): ExperienceRegisterPublic
    {

        $this->initialize($request, $experience, $user);

        $this->checkUserIsNotRegisteredInExperience();

        $this->checkRegisterCodeIsValid();

        $this->createRegisterInExperience();

        $this->processCodePayment();

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

    private function checkRegisterCodeIsValid()
    {

        $keyCode = new KeyCode($this->request->code);

        $this->registerCodeChecker->checkCodeIsValidForRegistration($keyCode);

        $this->registerCode = $this->codeRepository->findByCode($keyCode);
    }

    private function createRegisterInExperience()
    {
        $this->experienceRegisterPublic = $this->createExperienceRegisterCommand->handle($this->experience, $this->user);
    }

    private function processCodePayment()
    {

        $detailCollection = DetailCollection::fromItem($this->experienceRegisterPublic);

        $paymentDto = new CodePaymentDto($detailCollection, $this->user, $this->registerCode, $this->experience->price);

        return $this->payWithCodeCommand->handle($paymentDto);
    }
}
