<?php

namespace App\Src\ExperienceDomain\ExperienceRegister\Action;

use App\Src\ExperienceDomain\Experience\Exception\ExperienceIsPaid;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegister\Action\Command\CreateExperienceRegisterCommand;
use App\Src\ExperienceDomain\ExperienceRegister\Exception\UserAlreadyRegisteredInExperience;
use App\Src\ExperienceDomain\ExperienceRegister\Model\ExperienceRegister;
use App\Src\ExperienceDomain\ExperienceRegister\Repository\ExperienceRegisterRepository;
use App\Src\ExperienceDomain\ExperienceRegister\Request\RegisterExperienceRequest;
use App\Src\PaymentDomain\Payment\Action\Command\PayFreeCommand;
use App\Src\PaymentDomain\Payment\Service\FreePaymentDto;
use App\Src\PaymentDomain\PaymentDetail\Service\DetailCollection;
use App\Src\UserDomain\User\Model\UserPayable;

class RegisterUserWithFreeAction
{
    //construct
    private ExperienceRegisterRepository $experienceRegisterRepository;

    private PayFreeCommand $payFreeCommand;

    private CreateExperienceRegisterCommand $createExperienceRegisterCommand;

    //status
    private RegisterExperienceRequest $request;

    private Experience $experience;

    private ExperienceRegister $experienceRegister;

    private UserPayable $user;

    public function __construct(
        ExperienceRegisterRepository $experienceRegisterRepository,

        PayFreeCommand $payFreeCommand,
        CreateExperienceRegisterCommand $createExperienceRegisterCommand)
    {

        $this->payFreeCommand = $payFreeCommand;
        $this->createExperienceRegisterCommand = $createExperienceRegisterCommand;
        $this->experienceRegisterRepository = $experienceRegisterRepository;
    }

    public function handle(RegisterExperienceRequest $request, Experience $experience, UserPayable $user): ExperienceRegister
    {

        $this->initialize($request, $experience, $user);

        $this->checkExperienceIsFree();

        $this->checkUserIsNotRegisteredInExperience();

        $this->createRegisterInExperience();

        $this->processFreePayment();

        return $this->experienceRegister;
    }

    private function initialize(RegisterExperienceRequest $request, Experience $experience, UserPayable $user)
    {

        $this->request = $request;
        $this->experience = $experience;
        $this->user = $user;
    }

    private function checkExperienceIsFree()
    {

        if (! $this->experience->isFree()) {
            throw new ExperienceIsPaid();
        }
    }

    private function checkUserIsNotRegisteredInExperience()
    {

        if ($this->experienceRegisterRepository->checkUserInExperience($this->experience, $this->user)) {
            throw new UserAlreadyRegisteredInExperience();
        }
    }

    private function createRegisterInExperience()
    {
        $this->experienceRegister = $this->createExperienceRegisterCommand->handle($this->experience, $this->user);
    }

    private function processFreePayment()
    {
        $detailCollection = DetailCollection::fromItem($this->experienceRegister);

        $paymentDto = new FreePaymentDto($detailCollection, $this->user, $this->experience->price);

        return $this->payFreeCommand->handle($paymentDto);
    }
}
