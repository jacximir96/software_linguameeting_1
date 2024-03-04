<?php

namespace App\Src\CoachDomain\Coach\Action;

use App\Src\CoachDomain\BillingInfo\Action\Command\CreateBillingInfoDefaultCommand;
use App\Src\CoachDomain\BillingInfo\Model\BillingInfo;
use App\Src\CoachDomain\Coach\Event\CoachCreatedEvent;
use App\Src\CoachDomain\Coach\Request\CoachRequest;
use App\Src\CoachDomain\CoachInfo\Model\CoachInfo;
use App\Src\UserDomain\Password\Service\PasswordService;
use App\Src\UserDomain\User\Model\User;

class CreateCoachAction
{
    //construct
    private ProcessRequest $processRequest;

    private PasswordService $passwordService;

    private CreateBillingInfoDefaultCommand $createBillingInfoDefaultCommand;

    //status
    private CoachRequest $request;

    private User $coach;

    private string $plainPassword = '';

    public function __construct(ProcessRequest $processRequest, PasswordService $passwordService, CreateBillingInfoDefaultCommand $createBillingInfoDefaultCommand)
    {
        $this->processRequest = $processRequest;
        $this->passwordService = $passwordService;
        $this->createBillingInfoDefaultCommand = $createBillingInfoDefaultCommand;
    }

    public function handle(CoachRequest $request, User $executor): User
    {

        $this->initialize($request);

        $this->createPersonalData($executor);

        $this->updateCoachInfo();

        $this->createBillingInfo();

        $this->createHobbies();

        $this->updateProfileImage();

        event(new CoachCreatedEvent($this->coach, $this->plainPassword));

        $this->coach->sendEmailVerificationNotificationWithPassword($this->plainPassword);

        return $this->coach;
    }

    private function initialize(CoachRequest $request)
    {

        $this->request = $request;
    }

    private function createPersonalData(User $executor)
    {

        $this->plainPassword = $this->request->password ?? $this->passwordService->generatePassword();

        $this->coach = new User();
        $this->coach->password = $this->plainPassword;

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

    public function createHobbies()
    {
        $this->processRequest->createHobbies($this->request, $this->coach);
    }

    private function updateProfileImage()
    {
        $this->processRequest->updateProfileImage($this->request, $this->coach);
    }
}
