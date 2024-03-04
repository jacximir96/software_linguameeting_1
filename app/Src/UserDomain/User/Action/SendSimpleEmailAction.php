<?php

namespace App\Src\UserDomain\User\Action;

use App\Src\Shared\Model\ValueObject\EmailContent;
use App\Src\Shared\Service\IdCollection;
use App\Src\UserDomain\User\Mail\SimpleMailUser;
use App\Src\UserDomain\User\Repository\UserRepository;
use Illuminate\Support\Facades\Mail;

class SendSimpleEmailAction
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {

        $this->userRepository = $userRepository;
    }

    public function handle(IdCollection $userIdCollection, EmailContent $emailContent)
    {

        $users = $this->userRepository->obtainToSendEmail($userIdCollection->toArray());

        foreach ($users as $user) {
            Mail::to($user->email)->queue((new SimpleMailUser($user, $emailContent))->onQueue('emails'));
        }
    }
}
