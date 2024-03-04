<?php

namespace App\Src\MessagingDomain\Thread\Repository;

use App\Src\MessagingDomain\Thread\Model\Thread;
use App\Src\UserDomain\User\Model\User;

class ThreadRepository
{
    public function obtainInbox(User $user)
    {

        return Thread::query()
            ->with($this->relation())
            ->where('writer_id', '!=', $user->id)
            ->whereHas('participant', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('thread.created_at', 'desc')
            ->paginate(config('linguameeting.items_per_page'));
    }

    public function obtainLatestInboxNotRead(User $user, int $limit)
    {

        return Thread::query()
            ->with($this->relation())
            ->whereHas('participant', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->whereDoesntHave('read', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->paginate($limit);
    }

    public function obtainSent(User $user)
    {

        return Thread::query()
            ->with($this->relation())
            ->where('writer_id', '=', $user->id)
            ->orderBy('thread.created_at', 'desc')
            ->paginate(config('linguameeting.items_per_page'));

    }

    public function relation(): array
    {

        return [
            'message',
            'message.file',
            'message.user',
            'read',
            'participant',
            'participant.user',
            'writer',
        ];
    }
}
