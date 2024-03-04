<?php

namespace App\Src\MessagingDomain\Participant\Repository;

use App\Src\MessagingDomain\Participant\Model\Participant;
use App\Src\MessagingDomain\Thread\Model\Thread;
use App\Src\UserDomain\User\Model\User;

class ParticipantRepository
{
    public function checkParticipantExistsInTread(User $user, Thread $thread): bool
    {

        return Participant::query()
            ->where('thread_id', $thread->id)
            ->where('user_id', $user->id)
            ->exists();
    }
}
