<?php

namespace App\Src\MessagingDomain\ThreadRead\Action\Command;

use App\Src\MessagingDomain\Thread\Model\Thread;
use App\Src\MessagingDomain\ThreadRead\Model\ThreadRead;
use App\Src\MessagingDomain\ThreadRead\Repository\ThreadReadRepository;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class MarkThreadAsReadCommand
{
    private ThreadReadRepository $threadReadRepository;

    public function __construct(ThreadReadRepository $threadReadRepository)
    {

        $this->threadReadRepository = $threadReadRepository;
    }

    public function handle(Thread $thread, User $user): ThreadRead
    {

        $item = $this->threadReadRepository->getThreadReaded($thread, $user);

        if ($item) {
            return $item;
        }

        $new = new ThreadRead();
        $new->thread_id = $thread->id;
        $new->user_id = $user->id;
        $new->read_at = Carbon::now();
        $new->save();

        return $new;
    }
}
