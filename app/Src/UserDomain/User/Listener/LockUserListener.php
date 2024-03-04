<?php

namespace App\Src\UserDomain\User\Listener;

use App\Src\UserDomain\User\Action\LockUserAction;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Auth\Events\Lockout;

class LockUserListener
{
    private LockUserAction $lockUserAction;

    public function __construct(LockUserAction $lockUserAction)
    {

        $this->lockUserAction = $lockUserAction;
    }

    public function handle(Lockout $event)
    {

        $user = User::where('email', $event->request->email)->first();

        if ($user) {
            $this->lockUserAction->handle($user);
        }
    }
}
