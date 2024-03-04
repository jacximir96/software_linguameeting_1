<?php

namespace App\Src\MessagingDomain\ThreadRead\Repository;

use App\Src\MessagingDomain\Thread\Model\Thread;
use App\Src\MessagingDomain\ThreadRead\Model\ThreadRead;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class ThreadReadRepository
{
    public function getThreadReaded(Thread $thread, User $user): ?ThreadRead
    {

        return ThreadRead::query()
            ->where('thread_id', $thread->id)
            ->where('user_id', $user->id)
            ->first();
    }

    public function isThreadReaded(Thread $thread, User $user): bool
    {

        return ThreadRead::query()
            ->where('thread_id', $thread->id)
            ->where('user_id', $user->id)
            ->exists();
    }

    public function getNotReadByCoach(User $coach, int $paginate = null): Collection
    {

        $query = ThreadRead::query()
            ->with($this->relation())
            ->where()
            ->get();

    }

    public function relation(): array
    {

        return [
            'thread',
            'thread.write',
            'user',
        ];
    }
}
