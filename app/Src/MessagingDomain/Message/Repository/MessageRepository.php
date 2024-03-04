<?php

namespace App\Src\MessagingDomain\Message\Repository;

use App\Src\MessagingDomain\Message\Model\Message;
use App\Src\MessagingDomain\Thread\Model\Thread;

class MessageRepository
{
    public function getFirstMessageOfThread(Thread $thread): Message
    {

        return Message::query()
            ->where('thread_id', $thread->id)
            ->orderBy('id', 'asc')
            ->first();

    }

    public function getLastMessageOfThread(Thread $thread): ?Message
    {

        return Message::query()
            ->where('thread_id', $thread->id)
            ->orderBy('id', 'desc')
            ->first();

    }
}
