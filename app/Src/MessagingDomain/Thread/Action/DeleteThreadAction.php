<?php

namespace App\Src\MessagingDomain\Thread\Action;

use App\Src\MessagingDomain\Thread\Exception\UserIsNotOwner;
use App\Src\MessagingDomain\Thread\Model\Thread;
use App\Src\UserDomain\User\Model\User;

class DeleteThreadAction
{
    public function handle(Thread $thread, User $userWantDelete): Thread
    {

        if (! $thread->isOwner($userWantDelete)) {
            throw new UserIsNotOwner();
        }

        foreach ($thread->message as $message) {
            $message->file()->delete();
        }

        $thread->message()->delete();

        $thread->participant()->delete();

        $thread->read()->delete();

        $thread->delete();

        return $thread;
    }
}
