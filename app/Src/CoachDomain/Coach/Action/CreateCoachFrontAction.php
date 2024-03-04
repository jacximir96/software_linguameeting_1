<?php

namespace App\Src\CoachDomain\Coach\Action;

use App\Src\CoachDomain\BillingInfo\Action\Command\CreateBillingInfoDefaultCommand;
use App\Src\CoachDomain\BillingInfo\Model\BillingInfo;
use App\Src\CoachDomain\Coach\Event\CoachCreatedEvent;
use App\Src\CoachDomain\Coach\Request\CoachFrontRequest;
use App\Src\CoachDomain\CoachInfo\Model\CoachInfo;
use App\Src\UserDomain\Password\Service\PasswordService;
use App\Src\UserDomain\User\Model\User;

class CreateCoachFrontAction
{
    //construct
    private ProcessRequest $processRequest;

    private PasswordService $passwordService;

    private CreateBillingInfoDefaultCommand $createBillingInfoDefaultCommand;

    //status
    private CoachFrontRequest $request;

    private User $coach;

    private string $plainPassword = '';

    public function __construct(ProcessRequest $processRequest, PasswordService $passwordService, CreateBillingInfoDefaultCommand $createBillingInfoDefaultCommand)
    {
        $this->processRequest = $processRequest;
        $this->passwordService = $passwordService;
        $this->createBillingInfoDefaultCommand = $createBillingInfoDefaultCommand;
    }

    public function handle(CoachFrontRequest $request): User
    {

        $this->initialize($request);

        $this->createPersonalData();

        $this->updateCoachInfo();

        $this->createBillingInfo();

        event(new CoachCreatedEvent($this->coach, $this->plainPassword));

        $this->coach->sendEmailVerificationNotificationWithPassword($this->plainPassword);

        return $this->coach;
    }

    private function initialize(CoachFrontRequest $request)
    {

        $this->request = $request;
    }

    private function createPersonalData()
    {

        $this->plainPassword = $this->request->password ?? $this->passwordService->generatePassword();

        $this->coach = new User();

        $this->coach = $this->processRequest->updatePersonalData($this->request, $this->coach);

    }

    private function updateCoachInfo(): CoachInfo
    {
        $coachInfo = $this->createCoachInfo();

        return $this->processRequest->updateCoachInfo($this->request, $coachInfo);
    }

    private function createCoachInfo(): CoachInfo
    {

        $coachInfo = new CoachInfo();
        $coachInfo->user_id = $this->coach->id;
        $coachInfo->save();

        return $coachInfo;
    }

    private function createBillingInfo(): BillingInfo
    {

        return $this->createBillingInfoDefaultCommand->handle($this->coach);
    }

}
